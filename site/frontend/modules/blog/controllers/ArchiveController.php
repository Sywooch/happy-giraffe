<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 14/08/14
 * Time: 16:30
 */

class ArchiveController extends LiteController
{
    public function actionIndex($year, $month, $day)
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'DATE(created) = :date',
            'params' => array(':date' => implode('-', array($year, $month, $day))),
        ));

        $postCriteria = clone $criteria;
        $cookCriteria = clone $criteria;
        $cookCriteria->with = array('tags', 'author');
        $postCriteria->scopes[] = 'full';

        $dp = new MultiModelDataProvider(array(
            'CommunityContent' => $postCriteria,
            'CookRecipe' => $cookCriteria,
        ), 'created', array(
            'pagination' => array(
                'pageVar' => 'page',
                'pageSize' => 100,
            ),
        ));

        $this->pageTitle = (date('Y-m-d') == implode('-', array($year, $month, $day))) ? 'Записи сегодня' : 'Записи от ' . implode('.', array($year, $month, $day));
        $this->render('index', compact('dp', 'year', 'month', 'day'));
    }
} 