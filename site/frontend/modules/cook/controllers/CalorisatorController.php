<?php

class CalorisatorController extends HController
{
    //public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->pageTitle = 'Калоризатор';
        $basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'calorisator' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

        $units = Yii::app()->db->createCommand()->select('*')->from('cook__units')->where('parent_id IS NULL', array())->queryAll();

        $this->render('index', array('units' => $units));
    }


    public function actionAc($term)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('cookIngredientsNutritionals');
        $criteria->limit = 20;
        $criteria->compare('title', $term, true);

        $ingredients = CookIngredients::model()->findAll($criteria);

        foreach ($ingredients as $ing) {
            $i = array(
                'value' => $ing->title,
                'label' => $ing->title,
                'id' => $ing->id,
                'unit_id' => $ing->unit_id
            );
            foreach ($ing->cookIngredientsNutritionals as $nutritional)
                $i['nutritionals'][$nutritional->nutritional_id] = $nutritional->value;

            $result[] = $i;
        }
        if (Yii::app()->request->isAjaxRequest) {
            header('Content-type: application/json');
            echo CJSON::encode($result);
        } else {
            echo '<pre>' . print_r($result, true) . '</pre>';
        }
    }
}