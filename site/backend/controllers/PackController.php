<?php

class PackController extends BController
{
    public function actionIndex($id)
    {
        $model = AttributeSet::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $this->render('edit',array(
            'model'=>$model
        ));
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

    public function actionAttributeInSearch($id){
        $model = Attribute::model()->findByPk($id);
        if ($model->attribute_is_insearch)
            $model->attribute_is_insearch = 0;
        else
            $model->attribute_is_insearch = 1;

        echo $model->update(array('attribute_is_insearch'));
    }

    public function actionDeleteAttribute($id, $set_id){
        $model = Attribute::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
//        if ($model->delete()){
//            $model = AttributeSetMap::model()->findByAttributes(array(
//                'map_set_id'=>$set_id,
//                'map_attribute_id'=>$id,
//            ));
            echo $model->delete();
//        }
    }

    public function actionDeleteAttributeValue($id){
        $model = AttributeValue::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //        if ($model->delete()){
        //            $model = AttributeSetMap::model()->findByAttributes(array(
        //                'map_set_id'=>$set_id,
        //                'map_attribute_id'=>$id,
        //            ));
        AttributeValueMap::model()->deleteAll('map_value_id='.$id);
        echo $model->delete();
        //        }
    }

    public function actionAddAttrListElem(){
        $text = $_POST['text'];
        $id = $_POST['model_id'];
        if (empty($text))
            Yii::app()->end();

        $attr_val = new AttributeValue();
        $attr_val->value_value = $text;
        $attr_val->save();

        $attr_map_val = new AttributeValueMap();
        $attr_map_val->map_attribute_id = $id;
        $attr_map_val->map_value_id = $attr_val->value_id;
        $attr_map_val->save();

        $this->widget('SimpleFormInputWidget',array(
            'model'=>$attr_val,
            'attribute'=>'value_value'
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