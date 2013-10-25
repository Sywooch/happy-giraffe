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
    public static $indexes = array(
        'post' => 'communityText',
        'video' => 'communityVideo',
        'photo' => 'albumPhoto',
    );

    public static $scoring = array(
        'created DESC', //, @relevance DESC',
        'rate DESC', // @relevance DESC',
        'views DESC', // @relevance DESC',
    );

    public static $fields = array('title', 'preview');

    public static function search($query, $scoring, $perPage, $entity)
    {
        $index = $entity ? self::$indexes[$entity] : 'community';
        $_query = Str::prepareForSphinxSearch($query);

        $allSearch = $textSearch = Yii::app()->search->select('*')->from('community')->where($_query)->limit(0, 100000)->searchRaw();
        $allCount = count($allSearch['matches']);

        $textSearch = Yii::app()->search->select('*')->from('communityText')->where($_query)->limit(0, 100000)->searchRaw();
        $textCount = count($textSearch['matches']);

        $videoSearch = Yii::app()->search->select('*')->from('communityVideo')->where($_query)->limit(0, 100000)->searchRaw();
        $videoCount = count($videoSearch['matches']);

        $photoSearch = Yii::app()->search->select('*')->from('albumPhoto')->where($_query)->limit(0, 100000)->searchRaw();
        $photoCount = count($photoSearch['matches']);

        $pages = new CPagination();
        $pages->pageSize = (int)$perPage;
        $pages->itemCount = $allCount;

        $criteria = new stdClass();
        $criteria->from = $index;
        $criteria->select = '*';
        $criteria->paginator = $pages;
        $criteria->query = $_query;
        $criteria->orders = self::$scoring[$scoring];
        $resIterator = Yii::app()->search->search($criteria);

        //получение необходимых id для выборки
        $entities = array();
        foreach ($resIterator->getRawData() as $result)
            $entities[isset($result->modelname) ? $result->modelname : 'CommunityContent'][$result->id] = null;

        //выборка и создание моделей
        $results = array();
        foreach ($entities as $entity => $ids) {
            foreach ($ids as $id => $val) {
                $criteria = new CDbCriteria(array(
                    'index' => 'id',
                ));
                $criteria->compare('t.id', $id);
                if (isset(Yii::app()->controller->module->relatedModelCriteria[$entity]))
                    $criteria->mergeWith(new CDbCriteria(Yii::app()->controller->module->relatedModelCriteria[$entity]));
                $model = CActiveRecord::model($entity)->find($criteria);
                if ($model)
                    $results[] = $model;
            }
        }

        foreach ($results as &$r) {
            foreach (self::$fields as $f) {
                if (isset($r->$f)) {
                    $field = Yii::app()->search->buildExcerpts(array($r->$f), $index, $query);
                    $r->$f = $field[0];
                }
            }
        }


        $data = array(
            'total' => $allCount,
            'results' => $results,
            'facets' => array(
                'post' => $textCount,
                'video' => $videoCount,
                'photo' => $photoCount,
            ),
        );

        return $data;
    }
}