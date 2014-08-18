<?php

namespace site\frontend\modules\archive\controllers;

class DefaultController extends \LiteController
{
    /**
     * @sitemap
     */
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
                'pageSize' => 10,
            ),
        ));

        if ($dp->totalItemCount == 0) {
            \Yii::app()->clientScript->registerMetaTag('noindex,nofollow', 'robots');
        }

        $this->pageTitle = $this->meta_description = (date('Y-m-d') == implode('-', array($year, $month, $day))) ? 'Записи сегодня' : 'Записи от ' . implode('.', array($year, $month, $day));
        $this->render('index', compact('dp', 'year', 'month', 'day'));
    }

    /**
     * @sitemap
     */
    public function actionMap()
    {
        $sections = \CommunitySection::model()->with('clubs', 'clubs.communities')->findAll(array('index' => 'id'));

        $this->pageTitle = $this->meta_description = 'Карта сайта';
        $this->render('map', compact('sections'));
    }
}