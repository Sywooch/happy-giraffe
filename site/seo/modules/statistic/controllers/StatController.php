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
        Yii::import('site.frontend.modules.friends.models.*');
        Yii::import('site.frontend.modules.messaging.models.*');

        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('main-editor')
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
            $this->addEntityToFastList('moderators', $user_id);

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
        if ($days == 1){
            $users = $this->getUsers($last_date);
            $this->render('users_detail_stats', compact('last_date', 'date', 'period', 'users'));
        }else{
            $this->render('users_stats', compact('last_date', 'date', 'days', 'period'));
        }
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

        $sections = TrafficSection::model()->findAll();

        $this->render('groups_stats', compact('last_date', 'date', 'period', 'sections'));
    }

    public function getPeriod($date, $days)
    {
        if ($date != date("Y-m-d")) {
            if ($date == date("Y-m-d", strtotime('-1 day')) && $days == 1)
                return 'yesterday';
            return 'manual';
        }
        if ($days == 1)
            return 'today';
        if ($days == 7)
            return 'week';
        if ($days >= 29 && $days <= 32)
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

    public function getUsers($date)
    {
        $a1 = Yii::app()->db->createCommand()
            ->select('author_id')
            ->from('community__contents as t')
            ->where('t.created >= "'.$date.' 00:00:00" AND t.created <= "'.$date.' 23:59:59" AND users.group=0')
            ->join('users', 't.author_id=users.id')
            ->queryColumn();

        $a2 = Yii::app()->db->createCommand()
            ->select('author_id')
            ->from('comments as t')
            ->where('t.created >= "'.$date.' 00:00:00" AND t.created <= "'.$date.' 23:59:59" AND users.group=0')
            ->join('users', 't.author_id=users.id')
            ->queryColumn();

        $a3 = Yii::app()->db->createCommand()
            ->select('author_id')
            ->from('cook__recipes as t')
            ->where('t.created >= "'.$date.' 00:00:00" AND t.created <= "'.$date.' 23:59:59" AND users.group=0')
            ->join('users', 't.author_id=users.id')
            ->queryColumn();

        $a4 = Yii::app()->db->createCommand()
            ->select('author_id')
            ->from('album__photos as t')
            ->where('t.created >= "'.$date.' 00:00:00" AND t.created <= "'.$date.' 23:59:59" AND users.group=0')
            ->join('users', 't.author_id=users.id')
            ->queryColumn();

        $a5 = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('im__messages as t')
            ->where('t.created >= "'.$date.' 00:00:00" AND t.created <= "'.$date.' 23:59:59" AND users.group=0')
            ->join('users', 't.user_id=users.id')
            ->queryColumn();

        return array_unique(array_merge($a1, $a2, $a3, $a4, $a5));
    }
}
