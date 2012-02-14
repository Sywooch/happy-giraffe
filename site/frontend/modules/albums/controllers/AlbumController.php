<?php
class AlbumController extends AController
{
    public function actionIndex()
    {
        $dataProvider = Album::model()->findByUser(Yii::app()->user->id);
        $this->render('index', array(
            'dataProvider' => $dataProvider
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
}
