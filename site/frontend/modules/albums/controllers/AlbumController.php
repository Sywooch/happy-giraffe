<?php
class AlbumController extends AController
{
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
                $this->redirect(array('album/index'));
            else
                print_r($model->errors);
        }
        $this->render('form', array('model' => $model));
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
