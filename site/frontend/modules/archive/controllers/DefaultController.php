<?php

namespace site\frontend\modules\archive\controllers;

class DefaultController extends \LiteController
{

    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $cs = \Yii::app()->clientScript;
            $package = \Yii::app()->user->isGuest ? 'lite_archive' : 'lite_archive_user';
            $cs->registerPackage($package);
            $cs->useAMD = true;
            return true;
        }
    }

    /**
     * @sitemap
     */
    public function actionIndex($year, $month, $day)
    {
        if (!checkdate($month, $day, $year)) {
            throw new \CHttpException(404);
        }

        $dp = new \CActiveDataProvider(\site\frontend\modules\archive\models\Content::model()->byDay(mktime(1, 1, 1, $month, $day, $year)), array(
            'pagination' => array(
                'pageVar' => 'page',
                'pageSize' => 100,
            ),
        ));

        if ($dp->totalItemCount == 0) {
            \Yii::app()->clientScript->registerMetaTag('noindex,nofollow', 'robots');
        }

        if (date('Y') == $year && date('m') == $month && date('d') == $day) {
            $this->pageTitle = $this->meta_description = 'Записи на сегодня на Веселом Жирафе';
            $h1 = 'Записи на сегодня';
            \Yii::app()->clientScript->registerLinkTag('canonical', null, $this->createAbsoluteUrl('/' . $this->route, $this->actionParams));
        } else {
            $date = implode('.', array($day, $month, $year)) . ' г.';
            $this->pageTitle = $this->meta_description = 'Записи от ' . $date . ' на Веселом Жирафе';
            $h1 = 'Записи от ' . $date;
        }

        $this->render('index', compact('dp', 'year', 'month', 'day', 'h1'));
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
