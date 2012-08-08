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
        if (! Yii::app()->user->isGuest)
            UserAction::model()->add(Yii::app()->user->id, UserAction::USER_ACTION_USED_SERVICES, array('service' => 'calorisator'));
    }

    public function actionAc($term)
    {
        $ingredients = CookIngredient::model()->autoComplete($term, 20, true, true);
        header('Content-type: application/json');
        echo CJSON::encode($ingredients);
    }

}