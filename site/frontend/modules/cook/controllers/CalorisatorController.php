<?php

class CalorisatorController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
            'ac + ajaxOnly'
        );
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Счетчик калорий';
        $this->render('index');
    }

    public function actionAc($term)
    {
        $ingredients = CookIngredient::model()->autoComplete($term, 20, true, true);
        header('Content-type: application/json');
        echo CJSON::encode($ingredients);
    }

}