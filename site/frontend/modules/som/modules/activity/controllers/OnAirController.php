<?php
/**
 * @author Никита
 * @date 14/07/15
 */

namespace site\frontend\modules\som\modules\activity\controllers;


use site\frontend\modules\som\modules\activity\models\Activity;

class OnAirController extends \LiteController
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'actions' => array('index'),
                'users' => array('?'),
            ),
        );
    }

    public $litePackage = 'posts';

    public function actionIndex($filter = null)
    {
        $criteria = $this->getCriteria($filter);

        $this->render('index', compact('criteria', 'filter'));
    }

    public function actionWidget()
    {
        $this->widget('site\frontend\modules\som\modules\activity\widgets\ActivityWidget', array(
            'pageVar' => $_GET['pageVar'],
            'pageSize' => $_GET['pageSize'],
            'view' => $_GET['view'],
        ));
    }

    protected function getCriteria($filter)
    {
        $model = Activity::model();

        switch ($filter) {
            case 'comments':
                $model->onlyComments();
                break;
            case 'posts':
                $model->onlyPosts();
                break;
        }

        return $model->getDbCriteria();
    }
}