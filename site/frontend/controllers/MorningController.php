<?php
/**
 * Author: alexk984
 * Date: 11.04.12
 */
class MorningController extends HController
{
    public $layout = '//morning/layout';
    public $time = null;
    public $last_time = null;

    public function filters()
    {
        return array(
            'accessControl',
            'location,saveLocation,updatePos + onlyAjax'
        );
    }

    protected function beforeAction($action)
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->useAMD = true;
        return parent::beforeAction($action);
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex($date = null)
    {
        if ($date === null || empty($date)) {
            $date = '2012-06-21';
            Yii::app()->clientScript->registerLinkTag('canonical', null, $this->createAbsoluteUrl($this->route, array('date' => $date)));
            $empty_param = true;
        } else
            $empty_param = false;
        $this->last_time = strtotime(date("Y-m-d") . ' 00:00:00');

        if (strtotime($date) == strtotime(date("Y-m-d")))
            $this->pageTitle = 'Утро с Весёлым жирафом';
        else
            $this->pageTitle = 'Утро ' . Yii::app()->dateFormatter->format("d MMMM yyyy", $date) . ' с Весёлым жирафом';

        //check if no articles today
        $criteria = new CDbCriteria;
        $criteria->condition = 'type_id=4 AND created >= "' . date("Y-m-d") . ' 00:00:00" ';
        if (!Yii::app()->user->checkAccess('editMorning'))
            $criteria->condition .= ' AND is_published = 1';
        $count = CommunityContent::model()->with('morning')->count($criteria);
        if ($count == 0) {
            $this->last_time = strtotime(' - 1 day', $this->last_time);
        }

        $this->time = strtotime($date . ' 00:00:00');

        $criteria = new CDbCriteria;
        $criteria->order = 'morning.position ASC';
        $cond = 'type_id=4 AND created >= "' . $date . ' 00:00:00"' . ' AND created <= "' . $date . ' 23:59:59"';
        if (!Yii::app()->user->checkAccess('editMorning'))
            $cond .= ' AND is_published = 1';

        $criteria->condition = $cond;
        $count = CommunityContent::model()->with('morning')->count($criteria);
        if ($count == 0) {
            $date = date("Y-m-d", $this->last_time);
            $this->time = $this->last_time;
            $cond = 'type_id=4 AND created >= "' . $date . ' 00:00:00"' . ' AND created <= "' . $date . ' 23:59:59"';
            if (!Yii::app()->user->checkAccess('editMorning'))
                $cond .= ' AND is_published = 1';
            $criteria->condition = $cond;
        }
        $articles = CommunityContent::model()->with('morning', 'morning.photos')->findAll($criteria);

        if (empty($articles) && !Yii::app()->user->checkAccess('editMorning'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->breadcrumbs = array(
            'Утро с Весёлым жирафом' => array('morning/'),
            'Утро ' . Yii::app()->dateFormatter->format("d MMMM yyyy", strtotime($date))
        );

        $this->render('index', compact('articles', 'empty_param', 'date'));
    }

    public function actionView($id)
    {
        $article = CommunityContent::model()->with('morning', 'morning.photos')->findByPk($id);
        if ($article === null || $article->morning === null ||
            ($article->morning->is_published != 1 && !Yii::app()->user->checkAccess('editMorning'))
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->pageTitle = CHtml::encode($article->title);
        $this->time = strtotime(date("Y-m-d", strtotime($article->created)) . ' 00:00:00');

        if (date("Y-m-d", $this->time) == date("Y-m-d"))
            $this->breadcrumbs = array(
                'Утро с Весёлым жирафом' => array('morning/'),
                $article->title
            );
        else
            $this->breadcrumbs = array(
                'Утро с Весёлым жирафом' => array('morning/'),
                'Утро ' . Yii::app()->dateFormatter->format("d MMMM yyyy", $this->time) => $this->createUrl('morning/index', array('date' => date("Y-m-d", $this->time))),
                $article->title,
            );

        $this->render('view', compact('article'));
    }

    public function actionEdit($id = null)
    {
        if (Yii::app()->user->checkAccess('editMorning')) {
            $this->pageTitle = 'Утро с Весёлым жирафом - Редактирование';
            if ($id === null) {
                $this->breadcrumbs = array(
                    'Утро с Весёлым жирафом' => array('morning/'),
                    'Создание записи'
                );
                if (isset($_POST['title'])) {
                    $post = new CommunityContent();
                    $post->title = $_POST['title'];
                    $post->type_id = 4;
                    $post->author_id = 1;
                    if ($post->save()) {
                        $morning = new CommunityMorningPost();
                        $morning->content_id = $post->id;
                        if ($morning->save())
                            $this->redirect($this->createUrl('morning/edit', array('id' => $post->id)));
                        else {
                            $post->delete();
                            throw new CHttpException(402, 'Ошибка, обратитесь к разработчикам.');
                        }
                    }
                }
                $this->render('_create', compact('post'));
            } else {
                $this->breadcrumbs = array(
                    'Утро с Весёлым жирафом' => array('morning/'),
                    'Редактирование записи'
                );

                Yii::app()->clientScript->registerScriptFile('/javascripts/morning.js');
                $post = CommunityContent::model()->findByPk($id);
                $this->render('form', compact('post'));
            }
        } else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }

    public function actionLocation($id)
    {
        $post = CommunityContent::model()->findByPk($id);
        if ($post === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->renderPartial('loc', compact('post'));
    }

    public function actionSaveLocation()
    {
        $post = CommunityContent::model()->findByPk($_POST['id']);
        if ($post === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $post->morning->location = $_POST['location'];
        $post->morning->lat = $_POST['lat'];
        $post->morning->long = $_POST['long'];
        $post->morning->zoom = $_POST['zoom'];
        $file_name = $this->saveImage($_POST['lat'], $_POST['long'], $_POST['zoom']);
        $post->morning->location_image = $file_name;
        if ($post->morning->save()) {
            $response = array(
                'status' => true,
                'html' => $this->renderPartial('_loc', compact('post'), true)
            );
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionUploadPhoto()
    {
        $photo = new CommunityPhoto();
        $photo->post_id = Yii::app()->request->getPost('id');

        $dir = Yii::getPathOfAlias('site.common.uploads.photos.morning.originals') .
            DIRECTORY_SEPARATOR . $photo->post_id . DIRECTORY_SEPARATOR;

        if (!file_exists($dir)) {
            mkdir($dir);
            $handle = fopen($dir . DIRECTORY_SEPARATOR . 'index.html', 'x+');
            fclose($handle);
        }
        $_FILES['file']['type'] = strtolower($_FILES['file']['type']);
        $name = time() . $_FILES['file']['name'];
        copy($_FILES['file']['tmp_name'], $dir . $name);
        $photo->image = $name;

        if ($photo->save()) {
            $response = array(
                'status' => true,
                //'html' => $this->renderPartial('_photo', compact('photo'), true),
                'id' => $photo->id
            );
        } else {
            $response = array(
                'status' => false,
            );
        }
        echo "<script type='text/javascript'>document.domain = document.location.host;</script>";
        echo CJSON::encode($response);
    }

    public function actionPhoto()
    {
        $photo = CommunityPhoto::model()->findByPk(Yii::app()->request->getPost('id'));
        $this->renderPartial('_photo', compact('photo'));
    }

    public function actionRemovePhoto()
    {
        $id = Yii::app()->request->getPost('id');
        $attach = CommunityPhoto::model()->findByPk($id);
        if ($attach !== null) {
            if ($attach->delete()) {
                echo CJSON::encode(array('status' => true));
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array('status' => false));
    }

    public function actionPublicAll()
    {
        if (!Yii::app()->user->checkAccess('editMorning'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $posts = CommunityMorningPost::model()->findAll('is_published = 0 AND content_id IS NOT NULL ');
        foreach ($posts as $post) {
            $post->is_published = 1;
            $post->save(false);
            if (isset($post->content)) {
                $post->content->created = date("Y-m-d H:i:s");
                $post->content->save(false);
            }
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionRemove($id)
    {
        if (Yii::app()->user->checkAccess('editMorning')) {
            CommunityContent::model()->deleteByPk($id, 'type_id = 4');
        }
    }

    public function hasArticlesOnDay($date)
    {
        $cond = 'type_id=4 AND created >= "' . $date . ' 00:00:00"' . ' AND created <= "' . $date . ' 23:59:59" AND removed = 0';
        if (!Yii::app()->user->checkAccess('editMorning'))
            $cond .= ' AND is_published = 1';
        return CommunityContent::model()->with('morning')->count($cond) != 0;
    }

    public function actionRemoveLocation()
    {
        if (!Yii::app()->user->checkAccess('editMorning'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $post = CommunityContent::model()->findByPk($_POST['id']);
        if ($post === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $post->morning->location = null;
        $post->morning->location_image = null;
        $post->morning->save();
    }

    public function actionUpdatePos()
    {
        if (!Yii::app()->user->checkAccess('editMorning'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $post = CommunityContent::model()->findByPk(Yii::app()->request->getPost('id'));
        if ($post === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $post->morning->position = Yii::app()->request->getPost('pos');;
        echo CJSON::encode(array('status' => $post->morning->save()));
    }

    public function saveImage($lat, $lon, $zoom)
    {
        $dir = Yii::getPathOfAlias('site.frontend.www.upload.morning.location');
        $url = "http://maps.googleapis.com/maps/api/staticmap?center=$lat,$lon&zoom=$zoom&size=223x65&maptype=roadmap&sensor=false&language=ru";
        $name = substr(sha1(time()), 0, 7);
        while (file_exists($dir . DIRECTORY_SEPARATOR . $name)) {
            $name = substr(sha1(time()), 0, 7);
        }
        $name .= '.png';
        file_put_contents($dir . DIRECTORY_SEPARATOR . $name, file_get_contents($url));

        return $name;
    }
}