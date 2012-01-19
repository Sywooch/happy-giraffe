<?php

class ProductController extends BController
{
    public function actionCreate($category)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $title = Yii::app()->request->getParam('title');
            $product = new Product;
            $product->product_title = $title;

            if ($product->save()) {
                echo CJSON::encode(array('success' => true, 'id' => $product->product_id));
            } else
                echo CJSON::encode(array('success' => false));
            Yii::app()->end();
        }

        $attributeMap = AttributeSetMap::model()->findAll('map_set_id=3');

        $this->render('create', array(
            'category_id' => $category,
            'attributeMap' => $attributeMap,
            'model'=>new Product
        ));
    }

    public function actionUpdate($product_id){
        $model = $this->loadModel($product_id);
        $attributeMap = AttributeSetMap::model()->findAll('map_set_id=3');

        $this->render('create', array(
            'category_id' => $model->product_category_id,
            'attributeMap' => $attributeMap,
            'model'=>$model
        ));
    }

    public function actionSetAttributeValue()
    {
        $attr_id = Yii::app()->request->getPost('attr_id');
        $product_id = Yii::app()->request->getPost('product_id');
        $value = Yii::app()->request->getPost('value');

        $eav_id = Y::command()
            ->select('eav_id')
            ->from('shop_product_eav')
            ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
            ':eav_product_id' => $product_id,
            ':eav_attribute_id' => $attr_id,
        ))
            ->limit(1)
            ->queryScalar();

        if ($eav_id) {
            Y::command()
                ->update('shop_product_eav', array(
                'eav_attribute_value' => $value,
            ), 'eav_id=:eav_id', array(
                ':eav_id' => $eav_id,
            ));
        }
        else
        {
            Y::command()
                ->insert('shop_product_eav', array(
                'eav_product_id' => $product_id,
                'eav_attribute_id' => $attr_id,
                'eav_attribute_value' => $value,
            ));
        }
    }

    public function actionSetAttributeTextValue()
    {
        $attr_id = Yii::app()->request->getPost('attr_id');
        $product_id = Yii::app()->request->getPost('product_id');
        $value = Yii::app()->request->getPost('value');

        $eav_id = Y::command()
            ->select('eav_id')
            ->from('shop_product_eav_text')
            ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
            ':eav_product_id' => $product_id,
            ':eav_attribute_id' => $attr_id,
        ))
            ->limit(1)
            ->queryScalar();

        if ($eav_id) {
            Y::command()
                ->update('shop_product_eav_text', array(
                'eav_attribute_value' => $value,
            ), 'eav_id=:eav_id', array(
                ':eav_id' => $eav_id,
            ));
        }
        else
        {
            Y::command()
                ->insert('shop_product_eav_text', array(
                'eav_product_id' => $product_id,
                'eav_attribute_id' => $attr_id,
                'eav_attribute_value' => $value,
            ));
        }
    }

    /**
     * @param int $id model id
     * @return Product
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
