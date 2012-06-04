<?php

class CalorisatorController extends HController
{
    public function actionIndex()
    {
        $this->pageTitle = 'Калоризатор';
        $this->render('index');
    }

    public function actionAc($term)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('cookIngredientsNutritionals');
        $criteria->limit = 20;
        $criteria->compare('title', $term, true);

        $ingredients = CookIngredient::model()->findAll($criteria);

        foreach ($ingredients as $ing) {
            $i = array(
                'value' => $ing->title,
                'label' => $ing->title,
                'id' => $ing->id,
                'unit_id' => $ing->unit_id,
                'density' => $ing->density
            );
            foreach ($ing->cookIngredientsNutritionals as $nutritional)
                $i['nutritionals'][$nutritional->nutritional_id] = $nutritional->value;
            foreach ($ing->units as $unit)
                $i['units'][$unit->unit_id] = $unit->weight;

            $result[] = $i;
        }

        header('Content-type: application/json');
        echo CJSON::encode($result);
    }
}