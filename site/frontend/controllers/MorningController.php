<?php
/**
 * Author: alexk984
 * Date: 11.04.12
 */
class MorningController extends Controller
{
    public $layout = '//morning/layout';
    public $time = null;

    public function filters()
    {
        return array(
            'accessControl',
            //'addBaby,removeBaby,removePhoto,removeFutureBaby + onlyAjax'
        );
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
        if ($date === null || empty($date))
            $date = date("Y-m-d");

        $this->time = strtotime($date . ' 00:00:00');
        $cond = 'type_id=4 AND created >= "' . $date . ' 00:00:00"' . ' AND created <= "' . $date . ' 23:59:59"';
        if (!Yii::app()->user->checkAccess('edirMorning'))
            $cond .= ' AND is_published = 1';
        $articles = CommunityContent::model()->with('photoPost', 'photoPost.photos')->findAll($cond);
        $this->breadcrumbs = array(
            'Утро с Вёселым жирафом',
        );

        $this->render('index', compact('articles'));
    }

    public function actionView($id)
    {
        $article = CommunityContent::model()->with('photoPost', 'photoPost.photos')->findByPk($id);
        if ($article === null || ($article->photoPost->is_published != 1 && !Yii::app()->user->checkAccess('editMorning') ))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $this->time = strtotime(date("Y-m-d", strtotime($article->created)) . ' 00:00:00');
        $this->breadcrumbs = array(
            'Утро с Вёселым жирафом' => array('morning/'),
            $article->name
        );

        $this->render('view', compact('article'));
    }

    public function actionEdit($id = null)
    {
        if (Yii::app()->user->checkAccess('editMorning')) {
            if ($id === null) {
                if (isset($_POST['name'])) {
                    $post = new CommunityContent();
                    $post->name = $_POST['name'];
                    $post->type_id = 4;
                    $post->author_id = Yii::app()->user->getId();
                    if ($post->save()) {
                        $photoPost = new CommunityPhotoPost();
                        $photoPost->content_id = $post->id;
                        $photoPost->save();
                        $this->redirect($this->createUrl('morning/edit', array('id' => $post->id)));
                    }
                }
                $this->render('_create', compact('post'));
            }
            else {
                Yii::app()->clientScript->registerScriptFile('/javascripts/morning.js');
                $post = CommunityContent::model()->findByPk($id);
                $this->render('form', compact('post'));
            }
        }
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

        $post->photoPost->location = $_POST['location'];
        $post->photoPost->lat = $_POST['lat'];
        $post->photoPost->long = $_POST['long'];
        $post->photoPost->zoom = $_POST['zoom'];
        $file_name = $this->saveImage($_POST['lat'], $_POST['long'], $_POST['zoom']);
        $post->photoPost->location_image = $file_name;
        if ($post->photoPost->save()) {
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
        }
        else {
            $response = array(
                'status' => false,
            );
        }
        echo "<script type='text/javascript'>document.domain = document.location.host;</script>";
        echo CJSON::encode($response);
    }

    public function actionPhoto(){
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

    public function actionPublicAll(){
        CommunityPhotoPost::model()->updateAll(array('is_published'=>'1'), 'is_published = 0');
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}