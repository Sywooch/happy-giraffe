<?php
class CommunityController extends Controller
{

    public $layout = '//layouts/main';

    public $community;
    public $user;
    public $rubric_id;
    public $content_type_slug;

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'list', 'view', 'fixList', 'fixUsers', 'fixSave', 'fixUser', 'shortList', 'shortListContents', 'join', 'leave', 'purify', 'ping', 'map', 'rewrite', 'postRewrite'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions' => array('add', 'edit', 'addTravel', 'editTravel', 'delete', 'transfer'),
                'users' => array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Клубы';

        $categories = array(
            'Дети' => array(
                'items' => array(
                    'Беременность и роды' => 3,
                    'Дети до года' => 4,
                    'Дети старше года' => 4,
                    'Дошкольники' => 3,
                    'Школьники' => 4
                ),
                'css' => 'kids',
            ),
            'Мужчина & Женщина' => array('css' => 'manwoman', 'count' => 2),
            'Красота и здоровье' => array('css' => 'beauty', 'count' => 3),
            'Дом' => array('css' => 'home', 'count' => 5),
            'Интересы и увлечения' => array('css' => 'hobbies', 'count' => 4),
            'Отдых' => array('css' => 'rest', 'count' => 4),
        );
        $communities = Community::model()->public()->findAll();

        $top5 = Rating::model()->findTopWithEntity('CommunityContent', 5);
        $this->render('index', array(
            'communities' => $communities,
            'categories' => $categories,
            'top5' => $top5,
        ));
    }

    public function actionList($community_id, $rubric_id = null, $content_type_slug = null)
    {
        $this->layout = '//layouts/community';
        $this->community = Community::model()->with('rubrics')->findByPk($community_id);
        if ($this->community === null)
            throw new CHttpException(404, 'Клуб не найден');
        $this->rubric_id = $rubric_id;
        $this->content_type_slug = $content_type_slug;

        if ($rubric_id !== null) {
            $rubric = CommunityRubric::model()->findByPk($rubric_id);
            if ($rubric === null)
                throw new CHttpException(404, 'Рубрика не найдена');
            $this->pageTitle = 'Клуб «' . $this->community->name . '» – рубрика «' . $rubric->name . '» у Веселого Жирафа';
        } else {
            $this->pageTitle = 'Клуб «' . $this->community->name . '» - общение с Веселым Жирафом';
        }

        $contents = CommunityContent::model()->getContents($community_id, $rubric_id, $content_type_slug);

        $crumbs = array();
        $crumbs['Клубы'] = array('/community');
        if ($rubric_id !== null) {
            $crumbs[$this->community->name] = $this->community->url;
            $crumbs[] = $rubric->name;
        } else {
            $crumbs[] = $this->community->name;
        }
        $this->breadcrumbs = $crumbs;

        $this->render('list', array(
            'contents' => $contents,
        ));
    }

    public function getUrl($overwrite = array(), $route = 'community/list')
    {
        $params = array_filter(CMap::mergeArray(
            array(
                'community_id' => $this->community->id,
                'rubric_id' => isset($this->actionParams['rubric_id']) ? $this->actionParams['rubric_id'] : null,
                'content_type_slug' => isset($this->actionParams['content_type_slug']) ? $this->actionParams['content_type_slug'] : null,
            ),
            $overwrite
        ));

        return $this->createUrl($route, $params);
    }

    /**
     * @sitemap dataSource=getContentUrls
     */
    public function actionView($community_id, $content_type_slug, $content_id)
    {
        $this->layout = '//layouts/community';
        $content = CommunityContent::model()->active()->full()->findByPk($content_id);
        if ($content === null)
            throw new CHttpException(404, 'Такой записи не существует');
        if ($content->isFromBlog) {
            $this->layout = '//layouts/user_blog';
            $this->user = $content->rubric->user;
        }

        $this->community = Community::model()->with('rubrics')->findByPk($community_id);
        $this->rubric_id = $content->rubric->id;
        $this->content_type_slug = $content_type_slug;

        $this->pageTitle = (empty($content->meta_title)) ? $content->name : $content->name . ' \\ ' . $content->meta_title;

        if ($content->author_id == Yii::app()->user->id) {
            UserNotification::model()->deleteByEntity(UserNotification::NEW_COMMENT, $content);
            UserNotification::model()->deleteByEntity(UserNotification::NEW_REPLY, $content);
        }

        $this->breadcrumbs = array(
            'Клубы' => array('/community'),
            $this->community->name => $this->community->url,
            $content->rubric->name => $content->rubric->url,
            $content->name,
        );

        $this->render('view', array(
            'data' => $content,
        ));
    }

    public function actionEdit($content_id)
    {
        $model = CommunityContent::model()->full()->findByPk($content_id);
        if ($model === null)
            throw CHttpException(404, 'Запись не найдена');

        $this->community = $model->rubric->community;
        $community_id = $model->rubric->community->id;
        $rubric_id = $model->rubric->id;

        if (
            $model->author_id != Yii::app()->user->id &&
            ! Yii::app()->authManager->checkAccess('removeCommunityContent', Yii::app()->user->id, array('community_id' => $community_id)) &&
            ! Yii::app()->authManager->checkAccess('transfer post', Yii::app()->user->id)
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $content_type = $model->type;
        $slave_model = $model->content;
        $slave_model_name = get_class($slave_model);

        $communities = Community::model()->findAll();
        $rubrics = ($community_id == '') ? array() : CommunityRubric::model()->findAllByAttributes(array('community_id' => $community_id));

        if (isset($_POST['CommunityContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['CommunityContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);
                $this->redirect($model->url);
            }
        }

        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'communities' => $communities,
            'rubrics' => $rubrics,
            'community_id' => $community_id,
            'rubric_id' => $rubric_id,
            'content_type_slug' => $content_type->slug,
        ));
    }

    public function actionTransfer()
    {
        if (!Yii::app()->authManager->checkAccess('transfer post', Yii::app()->user->id))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $model = CommunityContent::model()->findByPk(Yii::app()->request->getPost('id'));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $model->attributes = $_POST['CommunityContent'];
        if ($model->save()) {
            UserNotification::model()->create(UserNotification::TRANSFERRED, array('entity' => $model));

            $url = $this->createUrl('community/view', array(
                'community_id' => $model->rubric->community->id,
                'content_type_slug' => $model->type->slug,
                'content_id' => $model->id));

            $response = array(
                'status' => true,
                'url' => $url
            );
        } else {
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionAdd($community_id = null, $rubric_id = null, $content_type_slug = 'post')
    {
        if (! Yii::app()->user->checkAccess('createClubPost', array(
            'user' => Yii::app()->user->model,
            'community_id' => $community_id,
        )))
            throw new CHttpException(403, 'Запрашиваемая вами страница не найдена.');

        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug));
        $model = new CommunityContent('default');
        $model->author_id = Yii::app()->user->id;
        $model->type_id = $content_type->id;
        $model->rubric_id = $rubric_id;
        $slave_model_name = 'Community' . ucfirst($content_type->slug);
        $slave_model = new $slave_model_name;

        $this->community = Community::model()->findByPk($community_id);
        $communities = Community::model()->findAll();
        $rubrics = ($community_id === null) ? array() : CommunityRubric::model()->findAllByAttributes(array('community_id' => $community_id));

        if (isset($_POST['CommunityContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['CommunityContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);
                $this->redirect($model->url);
            }
        }

        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'communities' => $communities,
            'rubrics' => $rubrics,
            'community_id' => $community_id,
            'rubric_id' => $rubric_id,
            'content_type_slug' => $content_type->slug,
        ));
    }

    public function actionAddTravel()
    {
        $community_id = 21;
        $rubric_id = 151;
        $community = Community::model()->findByPk($community_id);
        $content_types = CommunityContentType::model()->findAll();
        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => 'travel'));

        $content_model = new CommunityContent('default');
        $content_model->rubric_id = $rubric_id;
        $content_model->author_id = Yii::app()->user->id;
        $slave_model = new CommunityTravel;

        $waypoints = array();
        if (isset($_POST['CommunityContent'], $_POST['CommunityTravel'], $_POST['CommunityTravelWaypoint']))
        {
            $content_model->attributes = $_POST['CommunityContent'];
            $slave_model->attributes = $_POST['CommunityTravel'];
            $images = CUploadedFile::getInstancesByName('CommunityTravelImage[image]');

            $valid = $content_model->validate();
            $valid = $slave_model->validate() && $valid;

            foreach ($_POST['CommunityTravelWaypoint'] as $w)
            {
                if (! empty($w['city_id']) && ! empty($w['country_id']))
                {
                    $waypoint = new CommunityTravelWaypoint;
                    $waypoint->attributes = $w;
                    $valid = $waypoint->validate() && $valid;
                    $waypoints[] = $waypoint;
                }
            }

            $j = 0;
            foreach ($images as $i)
            {
                $valid = (! $i->hasError) && $valid;
                $slave_model->addError('name', 'Произошла ошибка при загрузке файла #' . ++$j . '.');
            }

            if ($valid)
            {
                $content_model->save(false);
                $slave_model->content_id = $content_model->id;
                $slave_model->save(false);
                foreach ($waypoints as $waypoint)
                {
                    $waypoint->travel_id = $slave_model->id;
                    $waypoint->save(false);
                }
                foreach ($images as $i)
                {
                    if ($i->saveAs(Yii::getPathOfAlias('webroot').'/upload/travels/original/'.$i->name))
                    {
                        $image = new CommunityTravelImage;
                        $image->image = $i->name;
                        $image->travel_id = $slave_model->id;
                        $image->save();

                        FileHandler::run(Yii::getPathOfAlias('webroot').'/upload/travels/original/'.$i->name, Yii::getPathOfAlias('webroot').'/upload/travels/thumb/'.$i->name, array(
                            'resize' => array(
                                'width' => 170,
                                'height' => 180,
                            ),
                        ));
                    }
                }
                $this->redirect(array('community/view', 'community_id' => $community_id, 'content_type_slug' => $content_model->type->slug, 'content_id' => $content_model->id));
            }
        }

        $this->render('add', array(
            'content_model' => $content_model,
            'slave_model' => $slave_model,
            'community' => $community,
            'content_types' => $content_types,
            'content_type' => $content_type,
            'community_id' => $community_id,
            'rubric_id' => $rubric_id,
            'waypoints' => $waypoints,
            'blog' => false,
        ));
    }

    public function actionEditTravel($id)
    {
        $community_id = 21;
        $rubric_id = 151;
        $community = Community::model()->findByPk($community_id);
        $content_types = CommunityContentType::model()->findAll();
        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => 'travel'));

        $content_model = CommunityContent::model()->with('travel.waypoints')->findByPk($id);
        if ($content_model === null)
        {
            throw new CHttpException(404, 'Такой записи не существует.');
        }
        $slave_model = $content_model->travel;

        $waypoints = array();
        if (isset($_POST['CommunityContent'], $_POST['CommunityTravel'], $_POST['CommunityTravelWaypoint']))
        {
            $content_model->attributes = $_POST['CommunityContent'];
            $slave_model->attributes = $_POST['CommunityTravel'];

            $valid = $content_model->validate();
            $valid = $slave_model->validate() && $valid;

            foreach ($_POST['CommunityTravelWaypoint'] as $w)
            {
                if (! empty($w['city_id']) && ! empty($w['country_id']))
                {
                    $waypoint = new CommunityTravelWaypoint;
                    $waypoint->attributes = $w;
                    $valid = $waypoint->validate() && $valid;
                    $waypoints[] = $waypoint;
                }
            }

            if ($valid)
            {
                $content_model->save(false);
                $slave_model->content_id = $content_model->id;
                $slave_model->save(false);
                CommunityTravelWaypoint::model()->deleteAllByAttributes(array('travel_id' => $slave_model->id));
                foreach ($waypoints as $waypoint)
                {
                    $waypoint->travel_id = $slave_model->id;
                    $waypoint->save(false);
                }
                $this->redirect(array('community/view', 'community_id' => $community_id, 'content_type_slug' => $content_model->type->slug, 'content_id' => $content_model->id));
            }
        }

        $this->render('add', array(
            'content_model' => $content_model,
            'slave_model' => $slave_model,
            'community' => $community,
            'content_types' => $content_types,
            'content_type' => $content_type,
            'community_id' => $community_id,
            'rubric_id' => $rubric_id,
            'waypoints' => $waypoints,
        ));
    }

    public function getContentUrls()
    {
        $models = Yii::app()->db->createCommand()
            ->select('club_community_content.id AS content_id, club_community_rubric.community_id AS community_id, club_community_content_type.slug AS content_type_slug')
            ->from('club_community_content')
            ->join('club_community_rubric', 'club_community_content.rubric_id = club_community_rubric.id')
            ->join('club_community_content_type', 'club_community_content.type_id = club_community_content_type.id')
            ->order('club_community_content.id ASC')
            ->queryAll();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => $model,
            );
        }
        return $data;
    }

    public function getCommunityUrls()
    {
        $models = Yii::app()->db->createCommand()
            ->select('club_community.id AS community_id')
            ->from('club_community')
            ->order('club_community.id ASC')
            ->queryAll();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => $model,
            );
        }
        return $data;
    }

    public function actionFixList()
    {
        $criteria = new CDbCriteria(
            array(
                'condition' => 't.id > :id_from AND t.id <= :id_till',
                'params' => array(
                    ':id_from' => 1647,
                    ':id_till' => 1968,
                ),
                'with' => array(
                    'type',
                    'rubric' => array(
                        'with' => array(
                            'community',
                        ),
                    ),
                ),
            )
        );

        $file = file_get_contents(Yii::getPathOfAlias('webroot') . '/fix.txt');
        $updated = array_unique(explode("\n", $file));
        $criteria->addNotInCondition('t.id', $updated);

        $contents = CommunityContent::model()->findAll($criteria);

        $this->render('fixlist', array(
            'contents' => $contents,
        ));
    }

    public function actionFixUsers()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $users = User::model()->findAll(array(
                'condition' => 'email LIKE :term',
                'params' => array(':term' => $_GET['term'] . '%'),
            ));

            $_users = array();
            foreach ($users as $user)
            {
                $_users[] = array(
                    'label' => $user->email,
                    'value' => $user->email,
                    'id' => $user->id,
                );
            }
            echo CJSON::encode($_users);
        }
    }

    public function actionFixSave()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $content = CommunityContent::model()->findByPk($_POST['content_id']);
            $content->author_id = $_POST['author_id'];
            if ($content->save())
            {
                file_put_contents(Yii::getPathOfAlias('webroot') . '/fix.txt', $_POST['content_id'] . "\n", FILE_APPEND);
            }
        }
    }

    public function actionFixUser()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $user = User::model()->findByPk($_POST['author_id']);
            $response = $this->renderPartial('fixuser', array('user' => $user), true);
            echo $response;
        }
    }

    public function actionShortList()
    {
        $contents = Community::model()->with('rubrics')->findAll();

        $this->render('shortList', array(
            'contents' => $contents,
        ));
    }

    public function actionShortListContents($rubric_id)
    {
        $model = CommunityRubric::model()->with(array('community', 'contents.type'))->findByPk($rubric_id);
        foreach ($model->contents as $c)
        {
            echo CHtml::tag('li', array(), '&nbsp;&nbsp;&nbsp;&nbsp;' . CHtml::link($c->name, array(
                'community/view',
                'community_id' => $model->community->id,
                'content_type_slug' => $c->type->slug,
                'content_id' => $c->id,
            )));
        }
    }

    public function actionJoin($action, $community_id)
    {
        $result = ($action == 'join') ? Yii::app()->user->model->addCommunity($community_id) : Yii::app()->user->model->delCommunity($community_id);

        if (Yii::app()->request->isAjaxRequest) {
            if ($result) {
                $response = array(
                    'status' => true,
                    'button' => $this->renderPartial('_joinButton', array(
                        'community_id' => $community_id,
                    ), true),
                    'inClub' => ($action == 'join')
                );
            }
            else {
                $response = array(
                    'status' => false,
                    'inClub' => ($action == 'join')
                );
            }

            echo CJSON::encode($response);
        } else {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    public function actionPurify($by_happy_giraffe = 1)
    {
        $dp = new CActiveDataProvider(CommunityContent::model()->full(), array(
            'criteria' => array(
                'condition' => 'by_happy_giraffe = :by AND type_id = 1 AND rubric.community_id IS NOT NULL',
                'params' => array(':by' => $by_happy_giraffe),
                'order' => 't.id ASC',
            ),
        ));

        $this->render('purify', array(
            'dp' => $dp,
        ));
    }

    public function actionPing2()
    {
        $key = '';
        $login = '';
        $search_id = '';

        $urls = '';
        $contents = CommunityContent::model()->findByAttributes(array(
            'by_happy_giraffe' => true,
        ));
        foreach ($contents as $c) {
            $urls .= $c->url . "%0A";
        }

        $data = array(
            'key' => $key,
            'login' => $login,
            'search_id' => $search_id,
            'urls' => $urls,
        );

        $ch = curl_init("http://site.yandex.ru/ping.xml");
        curl_setopt($ch, CURLOPT_POST, true);

    }

    public function actionPing()
    {
        $contents = CommunityContent::model()->findAllByAttributes(array(
            'by_happy_giraffe' => true,
        ), array(
            'limit' => 100,
            'order' => 'id ASC',
        ));

        foreach ($contents as $c) {
            echo $c->url . '<br />';
        }
    }

    public function actionMap()
    {
        $contents = CommunityContent::model()->findAllByAttributes(array(
            'by_happy_giraffe' => true,
        ), array(
            'limit' => 100,
            'offset' => 100,
            'order' => 'id ASC',
        ));

        $this->render('map', array(
            'contents' => $contents,
        ));
    }

    public function actionRewrite()
    {
        $dp = new CActiveDataProvider('CommunityContent', array(
            'criteria' => array(
                'condition' => 'editor_id = :editor_id',
                'params' => array(':editor_id' => Yii::app()->user->id),
                'order' => 't.id ASC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        $this->render('rewrite', array(
            'dp' => $dp,
        ));
    }

    public function actionPostRewrite()
    {
        if (Yii::app()->user->id == 18 || Yii::app()->user->id == 23) {
            $dp = new CActiveDataProvider(CommunityContent::model()->full(), array(
                'criteria' => array(
                    'condition' => 'edited = 1',
                    'order' => 't.id ASC',
                ),
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));

            $this->render('rewrite', array(
                'dp' => $dp,
            ));
        }
    }
}