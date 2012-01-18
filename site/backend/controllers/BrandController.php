<?php

class BrandController extends BController
{
    public function actionIndex($query = null)
    {
        $dataProvider = ProductBrand::model()->getAll($query);

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
