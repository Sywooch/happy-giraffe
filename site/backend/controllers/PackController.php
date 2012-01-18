<?php

class PackController extends BController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionIndex($id)
    {
        $model = AttributeSet::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        $this->render('edit', array(
            'model' => $model
        ));
    }

    public function actionCreateAttribute()
    {
        $model = new Attribute();
        if (isset($_POST['in_price']) && $_POST['in_price'] == 1)
            $model->attribute_in_price = 1;

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];
            $model->attribute_required = 1;

            if ($model->save()) {
                $map_model = new AttributeSetMap();
                $map_model->map_attribute_id = $model->attribute_id;
                $map_model->map_attribute_title = '';
                $map_model->map_set_id = $_POST['set_id'];
                $map_model->pos = $map_model->MaxPosition();
                if ($map_model->save())
                    echo CJSON::encode(array('success' => true, 'id' => $model->attribute_id));
                else
                    var_dump($map_model->getErrors());
            } else {

            }
        } else
            $this->renderPartial('_attribute_edit', array('model' => $model));
    }

    public function actionUpdateAttribute()
    {
        $id = $_POST['id'];
        $model = $this->loadModel($id);

        if (isset($_POST['Attribute'])) {
            $model->attributes = $_POST['Attribute'];

            if ($model->save()) {
                echo CJSON::encode(array('success' => true, 'id' => $model->attribute_id));
            }
        } else
            $this->renderPartial('_attribute_edit', array('model' => $model, 'no_list' => true));
    }

    public function actionAttributeView()
    {
        $id = $_POST['id'];
        $model = $this->loadModel($id);
        $this->renderPartial('_attribute_view', array(
            'model' => $model
        ));
    }

    public function actionDeleteAttribute($id, $set_id)
    {
        $model = Attribute::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //        if ($model->delete()){
        //            $model = AttributeSetMap::model()->findByAttributes(array(
        //                'map_set_id'=>$set_id,
        //                'map_attribute_id'=>$id,
        //            ));
        echo $model->delete();
        //        }
    }

    public function actionDeleteAttributeValue($id)
    {
        $model = AttributeValue::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        //        if ($model->delete()){
        //            $model = AttributeSetMap::model()->findByAttributes(array(
        //                'map_set_id'=>$set_id,
        //                'map_attribute_id'=>$id,
        //            ));
        AttributeValueMap::model()->deleteAll('map_value_id=' . $id);
        echo $model->delete();
        //        }
    }

    public function actionAddAttrListElem()
    {
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

        $this->widget('SimpleFormInputWidget', array(
            'model' => $attr_val,
            'attribute' => 'value_value'
        ));
    }

    public function actionGetMeasureOptions()
    {
        $model = AttributeMeasure::model()->findByPk($_POST['id']);
        $data = CHtml::listData($model->measureOptions, 'id', 'title');
        $htmlOptions = array();
        echo CHtml::listOptions(null, $data, $htmlOptions);
    }

    /**
     * @param integer the ID of the model to be loaded
     * @return Attribute
     */
    public function loadModel($id)
    {
        $model = Attribute::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionAttributePosition($id, $new_pos = null, $set_id = null)
    {
        if ($id == 'brand') {
            $set = AttributeSet::model()->findByPk($set_id);
            if ($new_pos == null){
                $set->brand_pos = 0;
                Yii::app()->db->createCommand('Update ' . AttributeSetMap::model()->tableName()
                    . ' SET pos = pos+1 WHERE map_set_id=' . $set_id)->execute();
            }
            else {
                $after = AttributeSetMap::model()->findByAttributes(array('map_attribute_id' => $new_pos));
                $new_pos = $after->pos;
                Yii::app()->db->createCommand('Update ' . AttributeSetMap::model()->tableName()
                    . ' SET pos = pos+1 WHERE pos > ' . $new_pos . ' AND map_set_id=' . $set_id)->execute();
                $set->brand_pos = $new_pos + 1;
            }
            $success = $set->update(array('brand_pos'));
        } else {
            $model = AttributeSetMap::model()->findByAttributes(array('map_attribute_id' => $id));
            $success = $model->MoveAfter($new_pos);
        }
        echo CJSON::encode(array('success' => $success));
    }

    public function actionGetSortBlock($set_id)
    {
        $model = AttributeSet::model()->findByPk($set_id);
        $this->renderPartial('_sorter', array('model' => $model));
    }
}