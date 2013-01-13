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
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.seo.models.*');
        Yii::import('site.frontend.modules.signal.models.*');
        Yii::import('site.frontend.modules.signal.components.*');
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.im.models.*');
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.cook.models.*');

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
        $month->calculate();
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
        $commentators = CommentatorWork::getWorkingCommentators();
        foreach ($commentators as $commentator) {
            $user = User::getUserById($commentator->user_id);

            try {
                $seo_user = new SeoUser;
                $seo_user->email = $user->email;
                $seo_user->name = $user->getFullName();
                $seo_user->id = $user->id;
                $seo_user->password = '33';
                $seo_user->owner_id = '33';
                $seo_user->related_user_id = $user->id;
                $seo_user->save();
            } catch (Exception $e) {

            }
        }
    }

    public $ga = null;

    public function actionSyncPageSeVisits()
    {
        $ids = array();
        $commentators = CommentatorWork::getWorkingCommentators();
        foreach ($commentators as $commentator)
            $ids [] = $commentator->user_id;

        $month = date("Y-m");
        $this->loginGa();

        $visits = SearchEngineVisits::model()->findAllByAttributes(array('month' => $month));
        foreach ($visits as $visit) {
            $article = $visit->page->getArticle();

            if ($article !== null && in_array($article->author_id, $ids)) {
                $visit->count = GApi::getUrlOrganicSearches($this->ga, $month . '-01', $month . '-' . $this->getLastPeriodDay($month), str_replace('http://www.happy-giraffe.ru', '', $visit->page->url), false);
                echo $visit->page->url . " - " . $visit->count . "\n";
                if (!empty($visit->count))
                    $visit->save();

                sleep(2);
            } elseif ($article === null) {
                echo "article IS NULL {$visit->page->url} \n";
            }
        }
    }

    public function actionLoadGaVisits()
    {
        $month = date("Y-m");
        $commentators = CommentatorWork::getWorkingCommentators();

        //test on some user
        foreach ($commentators as $key => $commentator)
            if ($commentator->user_id == 15385)
                unset($commentators[$key]);

        $this->loginGa();

        foreach ($commentators as $commentator) {
            $models = CommunityContent::model()->findAll('author_id = ' . $commentator->user_id);

            foreach ($models as $model) {
                $url = trim($model->url, '.');
                if (!empty($url)) {
                    $ga_visits = GApi::getUrlOrganicSearches($this->ga, $month . '-01', $month . '-' . date("d"), $url, false);
                    $my_visits = SearchEngineVisits::getVisits($url, $month);

                    if ($ga_visits > 0)
                        echo "$url ga:$ga_visits, my:$my_visits \n";

                    if ($ga_visits > 0 && $my_visits != $ga_visits) {
                        SearchEngineVisits::updateStats($url, $month, $ga_visits);
                    }
                }
            }
        }
    }

    public function getLastPeriodDay($period)
    {
        return str_pad(cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($period)), date('Y', strtotime($period))), 2, "0", STR_PAD_LEFT);
    }

    public function loginGa()
    {
        $this->ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $this->ga->setProfile('ga:53688414');
    }

}
