<?php

namespace site\frontend\modules\archive\controllers;

class DefaultController extends \LiteController
{
    public function actionIndex($year, $month, $day)
    {
        $criteria = new \CDbCriteria(array(
            'condition' => 'DATE(created) = :date',
            'params' => array(':date' => implode('-', array($year, $month, $day))),
        ));

        $postCriteria = clone $criteria;
        $cookCriteria = clone $criteria;
        $cookCriteria->with = array('tags', 'author');
        $postCriteria->scopes[] = 'full';

        $dp = new \MultiModelDataProvider(array(
            'CommunityContent' => $postCriteria,
            'CookRecipe' => $cookCriteria,
        ), 'created', array(
            'pagination' => array(
                'pageVar' => 'page',
                'pageSize' => 100,
            ),
        ));

        if ($dp->totalItemCount == 0) {
            \Yii::app()->clientScript->registerMetaTag('noindex,nofollow', 'robots');
        }

        $this->pageTitle = (date('Y-m-d') == implode('-', array($year, $month, $day))) ? 'Записи сегодня' : 'Записи от ' . implode('.', array($year, $month, $day));
        $this->render('index', compact('dp', 'year', 'month', 'day'));
    }

    public function actionMap()
    {
        $sections = \CommunitySection::model()->with('clubs', 'clubs.communities')->findAll(array('index' => 'id'));

        $this->pageTitle = 'Карта сайта';
        $this->render('map', compact('sections'));
    }
}