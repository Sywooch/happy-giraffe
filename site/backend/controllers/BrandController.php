<?php

class BrandController extends BController
{
    public function actionIndex()
    {
        $dataProvider = ProductBrand::model()->getAll();

        $onOffCount = array(
            'on' => ProductBrand::model()->count('active = 1'),
            'off' => ProductBrand::model()->count('active = 0'),
        );

        $this->render('index', array(
            'brands' => $dataProvider->data,
            'pages' => $dataProvider->pagination,
            'onOffCount' => $onOffCount,
        ));
    }
}
