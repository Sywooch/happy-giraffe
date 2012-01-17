<?php

class BrandController extends BController
{
    public function actionIndex()
    {
        $dataProvider = ProductBrand::model()->getAll();
        $this->render('index', array(
            'brands' => $dataProvider->data,
        ));
    }
}
