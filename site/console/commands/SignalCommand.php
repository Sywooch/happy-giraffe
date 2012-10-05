<?php
/**
 * User: alexk984
 * Date: 10.03.12
 *
 */
class SignalCommand extends CConsoleCommand
{
    public $moderators = array();

    public function beforeAction($action)
    {
        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.frontend.modules.signal.components.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.frontend.modules.im.models.*');

        return true;
    }

    /**
     * Если модератор за 5 имнут не выполнил задание, отменяем его.
     */
    public function actionIndex()
    {
        UserSignalResponse::CheckLate();
    }

    public function actionFriendInvites()
    {
        $this->loadModerators();
        $new_users = $this->getNewUsers();

        foreach ($new_users as $user_id) {
            if (rand(0, $this->getNum(3)) == 1) {
                $moder = $this->getModerator($user_id);
                if ($moder != null) {
                    $friendRequest = new FriendRequest();
                    $friendRequest->from_id = $moder;
                    $friendRequest->to_id = $user_id;
                    $friendRequest->save();
                }
            }
        }
    }

    public function getNewUsers()
    {
        $end_date = date("Y-m-d H:i:s", strtotime('-7 days'));
        return Yii::app()->db->createCommand()
            ->select('id')
            ->from('users')
            ->where('register_date > :date', array(':date' => $end_date))
            ->queryColumn();

    }

    public function getModerator($user_id)
    {
        shuffle($this->moderators);

        $friends = Yii::app()->db->createCommand()
            ->select('user1_id')
            ->from('friends')
            ->where('user2_id = :user_id', array(':user_id' => $user_id))
            ->union(
            Yii::app()->db->createCommand()
                ->select('user2_id')
                ->from('friends')
                ->where('user1_id = :user_id', array(':user_id' => $user_id))
                ->text
        )
            ->queryColumn();

        foreach ($this->moderators as $moder_id) {
            if (!in_array($moder_id, $friends))
                return $moder_id;
        }

        return null;
    }

    public function getNum($number_friends)
    {
        return round(144 / $number_friends);
    }

    public function loadModerators()
    {
        $this->moderators = Yii::app()->db->createCommand()
            ->select('userid')
            ->from('auth__assignments')
            ->where('itemname = "moderator"')
            ->queryColumn();
    }

    public function actionCommentatorsStats()
    {
        $month = CommentatorsMonthStats::model()->find(new EMongoCriteria(array(
            'conditions' => array(
                'period' => array('==' => date("Y-m"))
            ),
        )));
        if ($month === null) {
            $month = new CommentatorsMonthStats;
            $month->period = date("Y-m");
        }
        $month->calculate();
        $month->save();
    }

    public function actionCommentatorsEndMonth()
    {
        $month = CommentatorsMonthStats::model()->find(new EMongoCriteria(array(
            'conditions' => array(
                'period' => array('==' => date("Y-m", strtotime('-10 days')))
            ),
        )));
        $month->calculate();
    }

    public function actionPartialStats()
    {
        $month = CommentatorsMonthStats::model()->find(new EMongoCriteria(array(
            'conditions' => array(
                'period' => array('==' => date("Y-m"))
            ),
        )));
        if ($month === null) {
            $month = new CommentatorsMonthStats;
            $month->period = date("Y-m");
        }
        $month->calculate(false);
    }

    public function actionFixArticles()
    {
        $date = '2012-10-05';

        $commentators = CommentatorWork::model()->findAll();

        foreach ($commentators as $commentator) {
            $day = $commentator->getDay($date);

            if ($day !== null) {

                $criteria = new CDbCriteria;
                $criteria->condition = 'created >= "' . $date . ' 00:00:00" AND created <= "' . $date . ' 23:59:59"';
                $criteria->compare('author_id', $commentator->user_id);
                $criteria->order = 'created desc';
                $criteria->with = array(
                    'rubric' => array(
                        'condition' => 'user_id IS NULL'
                    )
                );

                $count = CommunityContent::model()->count($criteria);
                $day->club_posts = $count;
                $commentator->save();
            }
        }
    }

    public function actionTest()
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $ga->setProfile('ga:53688414');
        $ga->setDateRange('2012-09-01', '2012-09-30');

        try {
            $report = $ga->getReport(array(
                'metrics' => urlencode('ga:visitors'),
                'filters' => urlencode('ga:pagePath==' . '/user/' . 15385 . '/blog/*'),
            ));

            var_dump($report);
        } catch (Exception $err) {
            echo $err->getMessage();
        }
    }
}
