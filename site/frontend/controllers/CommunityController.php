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
        $last_mod = $this->lastModified();
        $filters = array(
            'accessControl',
        );

        if (Yii::app()->user->isGuest) {
            $filters [] = array(
                'CHttpCacheFilter + view',
                'lastModified' => $last_mod,
            );

//            $filters [] = array(
//                'COutputCache + view',
//                'duration' => 300,
//                'varyByParam' => array('content_id', 'Comment_page'),
//                'varyByExpression' => '"'.$last_mod.'"',
//            );
        }

        return $filters;
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('add', 'edit', 'delete', 'transfer', 'uploadImage'),
                'users' => array('?'),
            ),

        );
    }

    protected function beforeAction($action)
    {
        if (!Yii::app()->request->isAjaxRequest && !Yii::app()->user->isGuest)
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
        $content = CommunityContent::model()->with(array('rubric', 'type'))->findByPk($content_id);
        if ($content === null || $content->isFromBlog)
            throw new CHttpException(404, 'Такой записи не существует');

        if (!empty($content_type_slug) && !in_array($content_type_slug, array('post', 'video')))
            throw new CHttpException(404, 'Страницы не существует');

        if ($community_id != $content->rubric->community->id || $content_type_slug != $content->type->slug) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $content->url);
            Yii::app()->end();
        }

        if (!empty($content->uniqueness) && $content->uniqueness < 50)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        $this->community = Community::model()->with('rubrics')->cache(300)->findByPk($community_id);
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

        if (!Yii::app()->user->isGuest){
            NotificationRead::getInstance()->setContentModel($content);
            UserPostView::getInstance()->checkView(Yii::app()->user->id, $content->id);
        }

        $this->render('view', array(
            'data' => $content,
        ));
    }


    public function actionEdit($content_id)
    {
        $this->meta_title = 'Редактирование записи';
        $model = CommunityContent::model()->findByPk($content_id);
        $model->scenario = 'default';
        if ($model === null)
            throw new CHttpException(404, 'Запись не найдена');

        $this->community = $model->rubric->community;
        $community_id = $model->rubric->community->id;
        $rubric_id = $model->rubric->id;

        //если не имеет прав на редактирование
        if (
            $model->author_id != Yii::app()->user->id &&
            !Yii::app()->authManager->checkAccess('editCommunityContent', Yii::app()->user->id, array('community_id' => $community_id)) &&
            !Yii::app()->authManager->checkAccess('transfer post', Yii::app()->user->id)
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

        if (isset($_POST['CommunityContent'], $_POST[$slave_model_name])) {
            $model->attributes = $_POST['CommunityContent'];
            $slave_model->attributes = $_POST[$slave_model_name];

            if (Yii::app()->request->getPost('ajax') && $_POST['ajax'] === 'community-form') {
                echo CJSON::encode(CMap::mergeArray(CJSON::decode(CActiveForm::validate($model)), CJSON::decode(CActiveForm::validate($slave_model))));
                Yii::app()->end();
            }


            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid) {
                $model->save(false);
                $slave_model->content_id = $model->id;
                $slave_model->save(false);

                if (Yii::app()->user->checkAccess('photo_gallery')) {
                    if ($model->gallery)
                        $model->gallery->delete();
                    if (Yii::app()->request->getPost('CommunityContentGallery')) {
                        $gallery = new CommunityContentGallery;
                        $gallery->title = $_POST['CommunityContentGallery']['title'];
                        $gallery->content_id = $model->id;
                        if ($gallery->save() && ($items = Yii::app()->request->getPost('CommunityContentGalleryItem')) != null) {
                            foreach ($items as $item) {
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
        if (!Yii::app()->user->checkAccess('createClubPost', array(
            'user' => Yii::app()->user->model,
            'community_id' => $community_id,
        ))
        )
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

        if (isset($_POST['CommunityContent'], $_POST[$slave_model_name])) {
            $model->attributes = $_POST['CommunityContent'];
            $model->author_id = $model->by_happy_giraffe ? User::HAPPY_GIRAFFE : Yii::app()->user->id;
            $slave_model->attributes = $_POST[$slave_model_name];

            if (Yii::app()->request->getPost('ajax') && $_POST['ajax'] === 'community-form') {
                echo CJSON::encode(CMap::mergeArray(CJSON::decode(CActiveForm::validate($model)), CJSON::decode(CActiveForm::validate($slave_model))));
                Yii::app()->end();
            }

            $valid = $model->validate();
            $valid = $slave_model->validate() && $valid;

            if ($valid) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $success = $model->save(false);
                    if ($success) {
                        $slave_model->content_id = $model->id;
                        $success = $slave_model->save(false);
                        if (!$success)
                            $transaction->rollback();
                        else
                            $transaction->commit();
                    } else
                        $transaction->rollback();
                } catch (Exception $e) {
                    $transaction->rollback();
                }

                if (Yii::app()->request->getPost('CommunityContentGallery')) {
                    $gallery = new CommunityContentGallery;
                    $gallery->title = $_POST['CommunityContentGallery']['title'];
                    $gallery->content_id = $model->id;

                    $items = Yii::app()->request->getPost('CommunityContentGalleryItem');
                    if ($gallery->save() && $items) {
                        foreach ($items as $item) {
                            $gi = new CommunityContentGalleryItem();
                            $gi->attributes = array(
                                'gallery_id' => $gallery->id,
                                'photo_id' => $item['photo_id'],
                                'description' => $item['description']
                            );
                            $gi->save();
                        }
                    }

                    if (count($items) > 0) {
                        reset($items);
                        $item = current($items);
                        $slave_model->photo_id = $item['photo_id'];
                        $slave_model->update(array('photo_id'));
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
            $redirectUrl = Yii::app()->request->urlReferrer;

        $this->render($community_id == Community::COMMUNITY_NEWS ? 'form_news' : 'form', array(
            'model' => $model,
            'slave_model' => $slave_model,
            'communities' => $communities,
            'rubrics' => $rubrics,
            'community_id' => $community_id,
            'rubric_id' => $rubric_id,
            'content_type_slug' => $content_type->slug,
            'redirectUrl' => $redirectUrl
        ));
    }

    public function getCommunityUrls()
    {
        $models = Yii::app()->db->createCommand()
            ->select('community__forums.id AS community_id')
            ->from('community__forums')
            ->order('community__forums.id ASC')
            ->queryAll();
        foreach ($models as $model) {
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
        foreach ($users as $user) {
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
        if ($content->save()) {
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
        foreach ($model->contents as $c) {
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
            } else {
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
        $content = CommunityContent::model()->active()->findByPk($content_id);
        $this->user = $content->rubric->user;
        $this->community = Community::model()->with('rubrics')->findByPk($community_id);
        $this->rubric_id = $content->rubric->id;
        $this->content_type_slug = $content_type_slug;

        $this->render('upload_user_image', compact('content'));
    }

    public function actionPurify($by_happy_giraffe = 1)
    {
        $dp = new CActiveDataProvider(CommunityContent::model(), array(
            'criteria' => array(
                'with' => array('rubric'),
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
            $dp = new CActiveDataProvider(CommunityContent::model(), array(
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

    public function actionWeeklyMail()
    {
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
        $content_id = Yii::app()->request->getQuery('content_id');

        $sql = "SELECT
                    GREATEST(
                        COALESCE(MAX(c.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(c.updated), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.created), '0000-00-00 00:00:00'),
                        COALESCE(MAX(cm.updated), '0000-00-00 00:00:00')
                    )
                FROM community__contents c
                LEFT OUTER JOIN comments cm
                ON cm.entity = 'CommunityContent' AND cm.entity_id = :content_id
                WHERE c.id = :content_id";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':content_id', $content_id, PDO::PARAM_INT);
        $t1 = strtotime($command->queryScalar());

        //проверяем блок внутренней перелинковки
        $url = 'http://www.happy-giraffe.ru' . Yii::app()->request->getRequestUri();
        $t2 = InnerLinksBlock::model()->getUpTime($url);

        if (empty($t2))
            return $t1;

        return date("Y-m-d H:i:s", max($t1, $t2));
    }
}