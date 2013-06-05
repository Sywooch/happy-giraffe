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
    public static $fields = array('title', 'text');

    public static function search($query, $scoring, $perPage, $entity, $page)
    {
        $start = ($page - 1) * $perPage;

        $categoryFilters = $entity === null ? null : array('entity' => array($entity));
        $raw = Yii::app()->indexden->search('main', self::processQuery($query), $start, $perPage, $scoring, implode(',', self::$fields), null, $categoryFilters);

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
            $model = $entities[$modelName][$modelId];
            foreach (self::$fields as $f) {
                $snippetName = 'snippet_' . $f;
                if (! empty($document->$snippetName)) {
                    $snippetValue = $document->$snippetName;
                    $snippetValue = str_replace('<b>', '<span class="search-highlight">', $snippetValue);
                    $snippetValue = str_replace('</b>', '</span>', $snippetValue);
                    $attribute = $f == 'text' ? 'preview' : $f;
                    $model->$attribute = $snippetValue;
                }
            }
            $results[] = $model;
        }

        $data = array(
            'total' => $raw->matches,
            'results' => $results,
            'facets' => (array) $raw->facets->entity,
        );

        return $data;
    }

    protected static function processQuery($query)
    {
        return 'title:"' . $query . '" OR text:"' . $query . '"^2';
    }
}