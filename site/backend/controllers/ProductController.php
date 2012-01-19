<?php

class ProductController extends BController
{
    public function actionCreate($category){

        if (Yii::app()->request->isAjaxRequest){
            $title = Yii::app()->request->getParam('title');
            $product = new Product;
            $product->product_title = $title;

            if ($product->save()){
                echo CJSON::encode(array('success'=>true,'id'=>$product->product_id));
            }else
                echo CJSON::encode(array('success'=>false));
            Yii::app()->end();
        }

        $this->render('create',array(
            'category_id'=>$category
        ));
    }
}
