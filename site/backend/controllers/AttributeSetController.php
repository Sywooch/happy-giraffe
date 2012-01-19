<?php

class AttributeSetController extends BController
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function actionUpdate($id)
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

        $this->renderPartial('_attribute_value_view',array('attr_val'=>$attr_map_val));
    }

    public function actionGetMeasureOptions()
    {
        $model = AttributeMeasure::model()->findByPk(Yii::app()->request->getPost('id'));
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

    /**
     * Change attribute position
     */
    public function actionAttributePosition()
    {
        $id = Yii::app()->request->getPost('id');
        $new_pos = Yii::app()->request->getPost('new_pos');
        $set_id = Yii::app()->request->getPost('set_id');

        if ($id == 'brand') {
            $set = AttributeSet::model()->findByPk($set_id);
            if (empty($new_pos)) {
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

    /**
     * Show filter block
     */
    public function actionGetFilterBlock()
    {
        $set_id = Yii::app()->request->getPost('set_id');

        $model = AttributeSet::model()->findByPk($set_id);
        $this->renderPartial('_sorter', array('model' => $model));
    }
}