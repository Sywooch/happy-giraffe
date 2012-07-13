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

    public function actionIndex($date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null)
            $days = 7;
        else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;


        $this->render('index', compact('last_date', 'days'));
    }

    public function actionUserStats($user_id, $date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null)
            $days = 7;
        else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $this->render('user_stats', compact('last_date', 'days', 'user_id'));
    }

    public function actionGroupStats($date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null)
            $days = 7;
        else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $this->render('group_stats', compact('last_date', 'date', 'user_id'));
    }
}
