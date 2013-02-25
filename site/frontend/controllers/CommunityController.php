<?php
class CommunityController extends HController
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
            array(
                'CHttpCacheFilter + view',
                'lastModified' => $this->lastModified(),
            ),
//            array(
//                'COutputCache + view',
//                'duration' => 300,
//                'varyByParam' => array('content_id', 'Comment_page'),
//                'varyByExpression' => Yii::app()->user->id . $this->lastModified(),
//            ),
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('add', 'edit', 'addTravel', 'editTravel', 'delete', 'transfer', 'uploadImage'),
                'users' => array('?'),
            ),

        );
    }

    protected function beforeAction($action) {
        if (! Yii::app()->request->isAjaxRequest)
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/community.js');
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Клубы на Веселом Жирафе';

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
        $communities = Community::model()->public()->sorted()->findAll();

        $this->render('index', array(
            'communities' => $communities,
            'categories' => $categories,
        ));
    }

    public function actionList($community_id, $rubric_id = null, $content_type_slug = null)
    {
        if ($community_id == Community::COMMUNITY_VALENTINE)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->layout = ($community_id == Community::COMMUNITY_NEWS) ? '//layouts/news' : '//layouts/community';
        $this->community = Community::model()->with('rubrics')->findByPk($community_id);
        if ($this->community === null)
            throw new CHttpException(404, 'Клуб не найден');
        $this->rubric_id = $rubric_id;
        $this->content_type_slug = $content_type_slug;

        if (!empty($content_type_slug) && !in_array($content_type_slug, array('post', 'video')))
            throw new CHttpException(404, 'Страницы не существует');

        if ($rubric_id !== null) {
            $rubric = CommunityRubric::model()->findByPk($rubric_id);
            if ($rubric === null)
                throw new CHttpException(404, 'Рубрика не найдена');
            $this->pageTitle = 'Клуб «' . $this->community->title . '» – рубрика «' . $rubric->title . '» у Веселого Жирафа';
        } else {
            $this->pageTitle = 'Клуб «' . $this->community->title . '» - общение с Веселым Жирафом';
        }

        $contents = CommunityContent::model()->getContents($community_id, $rubric_id, $content_type_slug);

        $crumbs = array();
        if ($community_id !== Community::COMMUNITY_NEWS)
            $crumbs['Клубы'] = array('/community');
        if ($rubric_id !== null) {
            $crumbs[$this->community->title] = $this->community->url;
            $crumbs[] = $rubric->title;
        } else {
            $crumbs[] = $this->community->title;
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
     * @sitemap dataSource=sitemapView
     */
    public function actionView($community_id, $content_type_slug, $content_id, $lastPage = null, $ajax = null)
    {
        if ($community_id == Community::COMMUNITY_VALENTINE)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        /* <ИМПОРТ РЕЦЕПТОВ> */
        if ($community_id == 22) {
            Yii::import('application.modules.cook.models.CookRecipe');
            $recipe = CookRecipe::model()->find('content_id = :content_id', array(':content_id' => $content_id));
            if ($recipe !== null) {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: " . $recipe->url);
                Yii::app()->end();
            }
        }
        /* </ИМПОРТ РЕЦЕПТОВ> */

        $this->layout = ($community_id == Community::COMMUNITY_NEWS) ? '//layouts/news' : '//layouts/community';
        CommunityPost::model()->scenario = 'view';
        $content = CommunityContent::model()->full()->findByPk($content_id);
        if ($content === null)
            throw new CHttpException(404, 'Такой записи не существует');

        if (!empty($content_type_slug) && !in_array($content_type_slug, array('post', 'video')))
            throw new CHttpException(404, 'Страницы не существует');

        if ($content->isFromBlog)
            throw new CHttpException(404, 'Такой записи не существует');

        if ($community_id != $content->rubric->community->id || $content_type_slug != $content->type->slug) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        if (!empty($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        $this->community = Community::model()->with('rubrics')->findByPk($community_id);
        $this->rubric_id = $content->rubric->id;
        $this->content_type_slug = $content_type_slug;

        if (empty($this->meta_title))
            $this->meta_title = (empty($content->meta_title)) ? $content->title : $content->title . ' \\ ' . $content->meta_title;

        if ($community_id !== Community::COMMUNITY_NEWS) {
            $this->breadcrumbs = array(
                'Клубы' => array('/community'),
                $this->community->title => $this->community->url,
                $content->rubric->title => $content->rubric->url,
                $content->title,
            );
        } else {
            $this->breadcrumbs = array(
                $this->community->title => $this->community->url,
                $content->rubric->title => $content->rubric->url,
                $content->title,
            );
        }

        if (! Yii::app()->user->isGuest)
            UserNotification::model()->deleteByEntity($content, Yii::app()->user->id);

        $this->registerCounter();

        $this->render('view', array(
            'data' => $content,
        ));
    }

    public function actionEdit($content_id)
    {
        $this->meta_title = 'Редактирование записи';
        $model = CommunityContent::model()->full()->findByPk($content_id);
        $model->scenario = 'default';
        if ($model === null)
            throw new CHttpException(404, 'Запись не найдена');

        $this->community = $model->rubric->community;
        $community_id = $model->rubric->community->id;
        $rubric_id = $model->rubric->id;

        //если не имеет прав на редактирование
        if (
            $model->author_id != Yii::app()->user->id &&
            ! Yii::app()->authManager->checkAccess('editCommunityContent', Yii::app()->user->id, array('community_id' => $community_id)) &&
            ! Yii::app()->authManager->checkAccess('transfer post', Yii::app()->user->id)
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        //уволенный сотрудник
        if (UserAttributes::isFiredWorker(Yii::app()->user->id, $model->created))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $content_type = $model->type;
        $slave_model = $model->content;
        $slave_model_name = get_class($slave_model);

        $communities = Community::model()->findAll();
        $rubrics = ($community_id == '') ? array() : CommunityRubric::model()->findAll('community_id = :community_id AND parent_id IS NULL', array(':community_id' => $community_id));

        if (isset($_POST['CommunityContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['CommunityContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            if(Yii::app()->request->getPost('ajax') && $_POST['ajax']==='community-form')
            {
                echo CJSON::encode(CMap::mergeArray(CJSON::decode(CActiveForm::validate($model)), CJSON::decode(CActiveForm::validate($slave_model))));
                Yii::app()->end();
            }


            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);

                if($model->gallery)
                    $model->gallery->delete();
                if(Yii::app()->request->getPost('CommunityContentGallery'))
                {
                    $gallery = new CommunityContentGallery;
                    $gallery->title = $_POST['CommunityContentGallery']['title'];
                    $gallery->content_id = $model->id;
                    if($gallery->save() && ($items = Yii::app()->request->getPost('CommunityContentGalleryItem')) != null)
                    {
                        foreach($items as $item)
                        {
                            $gi = new CommunityContentGalleryItem();
                            $gi->attributes = array(
                                'gallery_id' => $gallery->id,
                                'photo_id' => $item['photo_id'],
                                'description' => $item['description']
                            );
                            $gi->save();
                        }
                    }
                }

                $this->redirect($model->url);
            }
        }

        $this->render($community_id == Community::COMMUNITY_NEWS ? 'form_news' : 'form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'communities' => $communities,
            'rubrics' => $rubrics,
            'community_id' => $community_id,
            'rubric_id' => $rubric_id,
            'content_type_slug' => $content_type->slug
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
        $model->type_id = $content_type->id;
        $model->rubric_id = $rubric_id;
        $slave_model_name = 'Community' . ucfirst($content_type->slug);
        $slave_model = new $slave_model_name;

        $this->community = Community::model()->findByPk($community_id);
        $communities = Community::model()->findAll();
        $rubrics = ($community_id === null) ? array() : CommunityRubric::model()->findAll('community_id = :community_id AND parent_id IS NULL', array(':community_id' => $community_id));

        if (isset($_POST['CommunityContent'], $_POST[$slave_model_name]))
        {
            $model->attributes = $_POST['CommunityContent'];
            $model->author_id = $model->by_happy_giraffe ? User::HAPPY_GIRAFFE : Yii::app()->user->id;
            $slave_model->attributes = $_POST[$slave_model_name];

            if(Yii::app()->request->getPost('ajax') && $_POST['ajax']==='community-form')
            {
                echo CJSON::encode(CMap::mergeArray(CJSON::decode(CActiveForm::validate($model)), CJSON::decode(CActiveForm::validate($slave_model))));
                Yii::app()->end();
            }

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid)
            {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $success = $model->save(false);
                    if ($success){
                        $slave_model->content_id = $model->id;
                        $success = $slave_model->save(false);
                        if (!$success)
                            $transaction->rollback();
                        else
                            $transaction->commit();
                    }
                    else
                        $transaction->rollback();
                } catch (Exception $e) {
                    $transaction->rollback();
                }

                if(Yii::app()->request->getPost('CommunityContentGallery'))
                {
                    $gallery = new CommunityContentGallery;
                    $gallery->title = $_POST['CommunityContentGallery']['title'];
                    $gallery->content_id = $model->id;
                    if($gallery->save() && $items = Yii::app()->request->getPost('CommunityContentGalleryItem'))
                    {
                        foreach($items as $item)
                        {
                            $gi = new CommunityContentGalleryItem();
                            $gi->attributes = array(
                                'gallery_id' => $gallery->id,
                                'photo_id' => $item['photo_id'],
                                'description' => $item['description']
                            );
                            $gi->save();
                        }
                    }
                }

//                $comet = new CometModel;
//                $comet->type = CometModel::CONTENTS_LIVE;
//                $comet->send('guest', array('newId' => $model->id));

                $model->sendEvent();
//                sleep(5);

                $this->redirect($model->url);
            }
        }

        if (isset($_POST['redirectUrl']))
            $redirectUrl = $_POST['redirectUrl'];
        else
            $redirectUrl =Yii::app()->request->urlReferrer;

        $this->render($community_id == Community::COMMUNITY_NEWS ? 'form_news' : 'form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'communities' => $communities,
            'rubrics' => $rubrics,
            'community_id' => $community_id,
            'rubric_id' => $rubric_id,
            'content_type_slug' => $content_type->slug,
            'redirectUrl'=>$redirectUrl
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
                $slave_model->addError('title', 'Произошла ошибка при загрузке файла #' . ++$j . '.');
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

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('c.id, c.created, c.updated, r.community_id, ct.slug')
            ->from('community__contents c')
            ->join('community__rubrics r', 'c.rubric_id = r.id')
            ->join('community__content_types ct', 'c.type_id = ct.id')
            ->where('r.community_id IS NOT NULL AND c.removed = 0 AND (c.uniqueness >= 50 OR c.uniqueness IS NULL)')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'content_id' => $model['id'],
                    'community_id' => $model['community_id'],
                    'content_type_slug' => $model['slug'],
                ),
                'priority' => 0.5,
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;
    }

    public function getCommunityUrls()
    {
        $models = Yii::app()->db->createCommand()
            ->select('community__communities.id AS community_id')
            ->from('community__communities')
            ->order('community__communities.id ASC')
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
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
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

    public function actionFixSave()
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        $content = CommunityContent::model()->findByPk($_POST['content_id']);
        $content->author_id = $_POST['author_id'];
        if ($content->save())
        {
            file_put_contents(Yii::getPathOfAlias('webroot') . '/fix.txt', $_POST['content_id'] . "\n", FILE_APPEND);
        }
    }

    public function actionFixUser()
    {
        if (!Yii::app()->request->isAjaxRequest)
            Yii::app()->end();
        $user = User::model()->findByPk($_POST['author_id']);
        $response = $this->renderPartial('fixuser', array('user' => $user), true);
        echo $response;
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
            echo CHtml::tag('li', array(), '&nbsp;&nbsp;&nbsp;&nbsp;' . CHtml::link($c->title, array(
                'community/view',
                'community_id' => $model->community->id,
                'content_type_slug' => $c->type->slug,
                'content_id' => $c->id,
            )));
        }
    }

    public function actionJoin($action, $community_id)
    {
        if (Yii::app()->user->isGuest)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        if (empty($community_id))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

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

    public function actionUploadImage($community_id, $content_type_slug, $content_id)
    {
        $this->layout = '//layouts/community';
        $content = CommunityContent::model()->active()->full()->findByPk($content_id);
        $this->user = $content->rubric->user;
        $this->community = Community::model()->with('rubrics')->findByPk($community_id);
        $this->rubric_id = $content->rubric->id;
        $this->content_type_slug = $content_type_slug;

        $this->render('upload_user_image', compact('content'));
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
                'condition' => 'editor_id = :editor_id AND (edited = 0 OR edited = 1)',
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
        if (Yii::app()->user->id == 18 || Yii::app()->user->id == 23 || Yii::app()->user->id == 10454) {
            $dp = new CActiveDataProvider(CommunityContent::model()->full(), array(
                'criteria' => array(
                    'condition' => 'edited = 1',
                    'order' => 't.id ASC',
                ),
                'pagination' => array(
                    'pageSize' => 100,
                ),
            ));

            $this->render('postRewrite', array(
                'dp' => $dp,
            ));
        }
    }

    public function actionStats()
    {
        $dp = new CActiveDataProvider('Community', array(
            'criteria' => array(
                'order' => 't.id ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));

        $this->render('stats', array(
            'dp' => $dp,
        ));
    }

    public function actionWeeklyMail(){
        if (!Yii::app()->user->checkAccess('manageFavourites'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->render('weekly_mail');
    }

    public function actionRecent($community_id)
    {
        $community = new Community;
        $community->id = $community_id;

        $this->renderPartial('_recent', compact('community'));
    }

    public function actionContacts()
    {
        $this->community = Community::model()->findByPk(Community::COMMUNITY_NEWS);
        $this->pageTitle = 'О нас';
        $this->layout = '//layouts/news';
        $this->render('contacts');
    }

//    public function actionAuthors()
//    {
//        $this->community = Community::model()->findByPk(Community::COMMUNITY_NEWS);
//        $this->pageTitle = 'Авторы';
//        $this->layout = '//layouts/news';
//        $this->render('authors');
//    }

    protected function lastModified()
    {
        if (! Yii::app()->user->isGuest)
            return null;

        $content_id = Yii::app()->request->getQuery('content_id');
        $community_id = Yii::app()->request->getQuery('community_id');

        $sql = "SELECT
                    GREATEST(
                        COALESCE(MAX(c.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(c.updated), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.updated), '0000-00-00 00:00:00')
                    )
                FROM community__contents c
                JOIN community__rubrics r
                ON c.rubric_id = r.id
                LEFT OUTER JOIN comments cm
                ON cm.entity = 'CommunityContent' AND cm.entity_id = :content_id
                WHERE r.community_id = :community_id";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $command->bindValue(':community_id', $community_id, PDO::PARAM_INT);
        return $command->queryScalar();
    }
}