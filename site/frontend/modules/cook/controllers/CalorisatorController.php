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
        $ingredient_keys = array();

        $criteria = new CDbCriteria;
        $criteria->with = array('nutritionals');
        $criteria->limit = 10;
        $criteria->compare('nutritionals.id', 4);
        $criteria->compare('title', $term . '%', true, 'AND', false);
        $ingredients = CookIngredient::model()->findAll($criteria);

        $result = array();
        foreach ($ingredients as $ing) {
            $ingredient_keys[] = $ing->id;
            $i = array('value' => $ing->title, 'label' => $ing->title, 'id' => $ing->id, 'unit_id' => $ing->unit_id, 'density' => $ing->density);

            if (empty($ing->nutritionals))
                continue;

            foreach ($ing->nutritionals as $nutritional)
                $i['nutritionals'][$nutritional->nutritional_id] = $nutritional->value;
            foreach ($ing->units as $unit)
                $i['units'][$unit->unit_id] = $unit->weight;

            $result[] = $i;
        }

        if (count($result) < 10) {
            $criteria = new CDbCriteria;
            $criteria->with = array('nutritionals');
            $criteria->limit = 10;
            $criteria->compare('nutritionals.id', 4);
            $criteria->compare('title', $term, true, 'AND', true);
            $ingredients = CookIngredient::model()->findAll($criteria);

            foreach ($ingredients as $ing) {
                if (!in_array($ing->id, $ingredient_keys)) {
                    $i = array('value' => $ing->title, 'label' => $ing->title, 'id' => $ing->id, 'unit_id' => $ing->unit_id, 'density' => $ing->density);
                    foreach ($ing->nutritionals as $nutritional)
                        $i['nutritionals'][$nutritional->nutritional_id] = $nutritional->value;
                    foreach ($ing->units as $unit)
                        $i['units'][$unit->unit_id] = $unit->weight;

                    $result[] = $i;
                }
            }
        }

        header('Content-type: application/json');
        echo CJSON::encode($result);
    }
}