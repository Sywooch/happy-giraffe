<?php
/**
 * Author: alexk984
 * Date: 13.07.12
 */
class StatController extends SController
{
    public $layout = '//layouts/writing';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('editor')
            && !Yii::app()->user->checkAccess('superuser')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex($date1 = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($days == null)
            $days = 7;

        $this->render('index', compact('last_date', 'days'));
    }

    public function actionUserStats($days = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($days == null)
            $days = 7;

        $this->render('index', compact('last_date', 'days'));
    }
}
