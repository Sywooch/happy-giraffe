<?php
class AlbumsController extends Controller
{
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
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $dataProvider = Album::model()->findByUser(Yii::app()->user->id);
        $this->render('index', array(
            'dataProvider' => $dataProvider,
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

    public function actionCreate()
    {
        $model = new Album;
        if(isset($_POST['Album']))
        {
            $model->attributes = $_POST['Album'];
            $model->user_id = Yii::app()->user->id;
            if($model->save())
                $this->redirect(array('albums/index'));
            else
                print_r($model->errors);
        }
        $this->render('form', array('model' => $model));
    }

    public function actionAddPhoto($a)
    {
        $album = Album::model()->findByPk($a);
        if (!$album)
            throw new CHttpException(404, 'Альбом не найден');

        if (isset($_FILES['file'])) {
            // HTML5 upload
            if (Yii::app()->request->isPostRequest) {
                $file = CUploadedFile::getInstanceByName('file');
                $model = new AlbumPhoto();
                $model->album_id = $a;
                $model->user_id = $album->user_id;
                $model->file = $file;
                if($model->create())
                    echo 1;
                else
                    echo 0;
                Yii::app()->end();
            }
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
            $this->render('add_photo', array(
                'album' => $album
            ));
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
}
