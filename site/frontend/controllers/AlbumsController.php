<?php
class AlbumsController extends Controller
{
    public function beforeAction($action)
    {
        if(!Yii::app()->request->isAjaxRequest)
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/album.js');
        return parent::beforeAction($action);
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
                'actions' => array('index'),
            ),
            array('deny',
                'users' => array('*'),
                'actions' => array('index'),
            ),
            array('allow',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $user = Yii::app()->user->model;
        $dataProvider = Album::model()->findByUser(Yii::app()->user->id);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'user' => $user,
        ));
    }

    public function actionUser($id)
    {
        $user = User::model()->findByPk($id);
        if(!$user)
            throw new CHttpException(404, 'Пользователь не найден');
        $dataProvider = Album::model()->findByUser($id);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'user' => $user,
        ));
    }

    public function actionView($id)
    {
        $model = Album::model()->findByPk($id);
        if(!$model)
            throw new CHttpException(404, 'Альбом не найден');
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionCreate($id = false)
    {
        $model = $id ? Album::model()->findByPk($id) : new Album;
        if($model->isNewRecord)
            $model->user_id = Yii::app()->user->id;
        if(isset($_POST['Album']))
        {
            $model->attributes = $_POST['Album'];
            if(isset($_POST['Photo']))
                $model->files = $_POST['Photo'];
            if($model->save())
                $this->redirect($id === false ? array('albums/index') : array('albums/view', 'id' => $id));
        }
        $this->render('form', array('model' => $model));
    }

    public function actionAddPhoto($a = false)
    {
        $instanse = isset($_FILES['Filedata']) ? 'Filedata' : 'file';
        if($a && $a != 'false')
        {
            $album = Album::model()->findByPk($a);
            if (!$album)
                throw new CHttpException(404, 'Альбом не найден');
        }
        else
            $album = false;

        if (isset($_FILES[$instanse]))
        {
            $file = CUploadedFile::getInstanceByName($instanse);
            $model = new AlbumPhoto();

            // Загрузка в новый альбом
            if(!$a || $a == 'false')
            {
                $model->file = $file;
                $model->saveFile(true);
                echo $model->templateUrl;
                Yii::app()->end();
            }

            $model->album_id = $a;
            $model->user_id = $album->user_id;
            $model->file = $file;
            $model->create();

            // SWF upload
            if (!Yii::app()->request->isPostRequest)
                Yii::app()->end();
        }

        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.js' => false,
                'jquery-ui.min.js' => false,
                'jquery.yiilistview.js' => false,
                'jquery.ba-bbq.js' => false,
                'jquery-ui.css' => false,
            );
            $this->renderPartial('add_photo', array(
                'album' => $album
            ), false, true);
        }
        else
        {
            $this->render('add_photo', array(
                'album' => $album
            ));
        }
    }

    public function actionPhoto($id)
    {
        $photo = AlbumPhoto::model()->findByPk($id);
        $this->render('photo', array(
            'photo' => $photo,
        ));
    }

    public function actionAttach()
    {
        $dataProvider = Album::model()->findByUser(Yii::app()->user->id);
        $this->renderPartial('attach_index', array(
            'dataProvider' => $dataProvider,
            'attach' => true,
        ));
    }

    public function actionAttachView($id)
    {
        $model = Album::model()->findByPk($id);
        if(!$model)
            throw new CHttpException(404, 'Альбом не найден');
        $this->renderPartial('attach_view', array(
            'model' => $model,
        ));
    }

    public function actionSaveAttach()
    {
        $model = new AttachPhoto;
        $model->attributes = $_POST;
        $model->save();
        if(Yii::app()->request->getPost('return_html'))
        {
            $this->renderPartial('site.frontend.widgets.fileAttach.views._list', array(
                'attaches' => AttachPhoto::model()->findByEntity($_POST['entity'], $_POST['entity_id']),
            ));
        }
    }

    public function actionEditDescription($id)
    {
        $model = Album::model()->findByPk($id);
        if(!Yii::app()->request->isAjaxRequest || Yii::app()->user->id != $model->user_id || ($text = Yii::app()->request->getPost('text')) === false)
            Yii::app()->end();
        $model->description = $text;
        $model->save();
    }
}
