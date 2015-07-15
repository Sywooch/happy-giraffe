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
                'users' => array('?'),
            ),
        );
    }

    public $litePackage = 'posts';

    public function actionIndex($filter = 'all')
    {
        $criteria = $this->getCriteria($filter);
        $this->render('index', compact('criteria'));
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