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

    public static $fields = array('title', 'text');

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
        $pages->pageSize = (int) $perPage;
        $pages->itemCount = $allCount;

        $criteria = new stdClass();
        $criteria->from = $index;
        $criteria->select = '*';
        $criteria->paginator = $pages;
        $criteria->query = $_query;
        $resIterator = Yii::app()->search->search($criteria);

        $ids = array_map(function($result) {
            return $result->id;
        }, $resIterator->getRawData());

        $dbCriteria = new CDbCriteria();
        $dbCriteria->addInCondition('t.id', $ids);
        $results = CommunityContent::model()->full()->findAll($dbCriteria);
        foreach ($results as &$r) {
            $name = Yii::app()->search->buildExcerpts(array($r->title), $index, $query);
            $r->title = $name[0];
            $text = Yii::app()->search->buildExcerpts(array($r->preview), $index, $query);
            $r->preview = $text[0];
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