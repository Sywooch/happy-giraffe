<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 6/3/13
 * Time: 4:35 PM
 * To change this template use File | Settings | File Templates.
 */

class SearchManager
{
    public static function search($query)
    {
        $raw = Yii::app()->indexden->search('main', $query);

        $entities = array();
        foreach ($raw->results as $document) {
            list($modelName, $modelId) = explode('_', $document->docid);
            $entities[$modelName][$modelId] = null;
        }

        //выборка и создание моделей
        foreach ($entities as $entity => $ids) {
            $criteria = new CDbCriteria(array(
                'index' => 'id',
            ));
            $criteria->addInCondition('t.id', array_keys($ids));
            if (isset(Yii::app()->controller->module->relatedModelCriteria[$entity]))
                $criteria->mergeWith(new CDbCriteria(Yii::app()->controller->module->relatedModelCriteria[$entity]));
            $models = CActiveRecord::model($entity)->findAll($criteria);
            foreach ($models as $m)
                $entities[$entity][$m->id] = $m;
        }

        $results = array();
        foreach ($raw->results as $document) {
            list($modelName, $modelId) = explode('_', $document->docid);
            $results[] = $entities[$modelName][$modelId];
        }

        $data = array(
            'total' => $raw->matches,
            'results' => $results,
        );

        return $data;
    }
}


//получение необходимых id для выборки
$entities = array();
foreach ($favourites as $favourite)
    $entities[$favourite->model_name][$favourite->model_id] = null;

//выборка и создание моделей
foreach ($entities as $entity => $ids) {
    $criteria = new CDbCriteria(array(
        'index' => 'id',
    ));
    $criteria->addInCondition('t.id', array_keys($ids));
    if (isset(Yii::app()->controller->module->relatedModelCriteria[$entity]))
        $criteria->mergeWith(new CDbCriteria(Yii::app()->controller->module->relatedModelCriteria[$entity]));
    $models = CActiveRecord::model($entity)->findAll($criteria);
    foreach ($models as $m)
        $entities[$entity][$m->id] = $m;
}

//присваивание моделей соответсвующим элементам избранного
foreach ($favourites as $favourite)
    $favourite->relatedModel = $entities[$favourite->model_name][$favourite->model_id];