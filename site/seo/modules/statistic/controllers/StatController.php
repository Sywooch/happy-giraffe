<?php
/**
 * Author: alexk984
 * Date: 13.07.12
 */
class StatController extends SController
{
    public $layout = '//layouts/statistic';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('editor')
            && !Yii::app()->user->checkAccess('superuser')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionModerators($user_id = null, $date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null){
            $date = date("Y-m-d");
            $days = 1;
        }
        else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $period = $this->getPeriod($last_date, $days);
        $moderators = $this->getModerators();
        $this->render('moderator_stats', compact('last_date', 'date', 'days', 'moderators', 'period'));
    }

    public function actionUsers($date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null)
            $days = 7;
        else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $period = $this->getPeriod($last_date, $days);
        $this->render('user_stats', compact('last_date', 'date', 'days', 'period'));
    }

    public function actionGroups($date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null){
            $date = date("Y-m-d");
            $days = 1;
        }
        else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $period = $this->getPeriod($last_date, $days);
        $this->render('group_stats', compact('last_date', 'date', 'period'));
    }

    public function getPeriod($date, $days)
    {
        if ($date !== date("Y-m-d")){
            if ($date == date("Y-m-d", strtotime('-1 day')) && $days == 1)
                return 'yesterday';
            return 'manual';
        }
        if ($days == 1)
            return 'today';
        if ($days == 7)
            return 'week';

        return 'month';
    }

    public function getModerators()
    {
        return Yii::app()->db->createCommand()
            ->select('userid')
            ->from('auth__assignments')
            ->where('itemname = "moderator"')
            ->queryColumn();
    }
}
