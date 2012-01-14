<?php

class PackController extends BController
{
    public function actionIndex()
    {
        $this->render('edit');
    }

    public function actionCreateAttribute()
    {
        $model = new Attribute();

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];
            if ($model->save()){
                echo CJSON::encode(array('success'=>true));
            }
        }else
            $this->renderPartial('_attribute_edit', array('model' => $model));
    }

    public function actionUpdateAttribute($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];
            if ($model->save()){
                echo CJSON::encode(array('success'=>true));
            }
        }else
            $this->renderPartial('_attribute_edit', array('model' => $model));
    }

    public function actionAttributeView()
    {
        $model = new Attribute();
        $model->attribute_title = 'sfjkjsfh';
        $model->attribute_type = Attribute::TYPE_BOOL;

        $this->render('_attribute_view', array(
            'model' => $model
        ));
    }

    /**
     * @param integer the ID of the model to be loaded
     * @return Attribute
     */
    public function loadModel($id)
    {
        $model = Attribute::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}