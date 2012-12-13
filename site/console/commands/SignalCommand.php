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

    public function actionPriority()
    {
        //calc user priority
        $criteria = new CDbCriteria;
        $criteria->offset = 0;
        $criteria->limit = 100;
        $criteria->condition = 'register_date > :register_date';
        $criteria->params = array(':register_date' => date("Y-m-d H:i:s", strtotime('-3 month')));
        $criteria->compare('`group`', UserGroup::USER);
        $criteria->with = array('communityContentsCount', 'priority');

        $users = 1;
        while (!empty($users)) {
            $users = User::model()->findAll($criteria);

            foreach ($users as $user) {
                //если больше 5-ти постов, максимальный приоритет
                if ($user->communityContentsCount >= 5) {
                    $user->priority->priority = 20;
                    $user->priority->update(array('priority'));
                }

                //если комментировали вчера, уменьшаем приоритет
            }

            $criteria->offset += 100;
        }
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

    public function actionFix()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $commentators = CommentatorWork::model()->findAll();

        foreach ($commentators as $commentator) {
            echo $commentator->user_id."\n";
            $commentator->calcCurrentClub(1);
            $commentator->save();
        }
    }

    public function actionCommentator($id)
    {
        $month = CommentatorsMonthStats::model()->find(new EMongoCriteria(array(
            'conditions' => array(
                'period' => array('==' => date("Y-m"))
            ),
        )));
        $month->calculateCommentator($id);
    }

    public function actionAddCommentatorsToSeo()
    {
        Yii::import('site.seo.models.*');
        $commentators = CommentatorWork::getWorkingCommentators();
        foreach ($commentators as $commentator) {
            $user = User::getUserById($commentator->user_id);

            try{
                $seo_user = new SeoUser;
                $seo_user->email = $user->email;
                $seo_user->name = $user->getFullName();
                $seo_user->id = $user->id;
                $seo_user->password = '33';
                $seo_user->owner_id = '33';
                $seo_user->related_user_id = $user->id;
                $seo_user->save();
            }catch (Exception $e){

            }
        }
    }
}
