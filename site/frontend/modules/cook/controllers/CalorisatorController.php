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
        $ingredients = CookIngredient::model()->findByNameWithCalories($term);
        $result = array();

        foreach ($ingredients as $ing) {
            $i = array('value' => $ing->title, 'label' => $ing->title, 'id' => $ing->id, 'unit_id' => $ing->unit_id, 'density' => $ing->density);

            foreach ($ing->nutritionals as $nutritional)
                $i['nutritionals'][$nutritional->nutritional_id] = $nutritional->value;
            foreach ($ing->units as $unit)
                $i['units'][$unit->unit_id] = $unit->weight;

            $result[] = $i;
        }

        header('Content-type: application/json');
        echo CJSON::encode($result);
    }

}