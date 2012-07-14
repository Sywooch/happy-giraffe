<?php
/**
 * Author: alexk984
 * Date: 13.07.12
 */
class StatController extends SController
{
    public $layout = '//layouts/statistic';
    public $pageTitle = 'СТАТИСТИКА';

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
        if ($date == null) {
            $date = date("Y-m-d");
            if ($user_id == null)
                $days = 1;
            else
                $days = 7;
        } else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $period = $this->getPeriod($last_date, $days);
        $moderators = $this->getModerators();
        if ($user_id === null) {
            $this->render('moderators_stats', compact('last_date', 'date', 'days', 'moderators', 'period'));
        } else {
            $moderators = Yii::app()->user->getState('moderators');
            if (!is_array($moderators))
                $moderators = array($user_id);
            elseif (!in_array($user_id, $moderators))
                $moderators[] = $user_id;
            Yii::app()->user->setState('moderators', $moderators);

            $this->render('moderator_stats', compact('last_date', 'date', 'days', 'user_id', 'period'));
        }
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
        $this->render('users_stats', compact('last_date', 'date', 'days', 'period'));
    }

    public function actionGroups($date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null) {
            $date = date("Y-m-d");
            $days = 1;
        } else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $period = $this->getPeriod($last_date, $days);
        $this->render('groups_stats', compact('last_date', 'date', 'period'));
    }

    public function actionRemoveUser()
    {
        $moderators = Yii::app()->user->getState('moderators');
        $user_id = Yii::app()->request->getPost('user_id');
        foreach ($moderators as $key => $moderator)
            if ($moderator == $user_id)
                unset($moderators[$key]);
        Yii::app()->user->setState('moderators', $moderators);
        echo CJSON::encode(array('status' => true));
    }

    public function getPeriod($date, $days)
    {
        if ($date !== date("Y-m-d")) {
            if ($date == date("Y-m-d", strtotime('-1 day')) && $days == 1)
                return 'yesterday';
            return 'manual';
        }
        if ($days == 1)
            return 'today';
        if ($days == 7)
            return 'week';
        if ($days > 28 && $days < 32)
            return 'month';

        return 'manual';
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
