<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */
class ScoresCommand extends CConsoleCommand
{

    public function beforeAction()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.frontend.modules.scores.models.input.*');
        Yii::import('site.frontend.modules.scores.components.*');
        Yii::import('site.frontend.modules.scores.components.awards.*');
        Yii::import('site.frontend.modules.scores.components.awards.clubs.*');

        return true;
    }

    /**
     * Нужно для объдинения в группы оповещений о набранных баллах. Просматриваем все открытые записи о начислении
     * баллов и если время закрывать, то закрываем. После закрытия оно отобразиться в статистике
     *
     * Раз в 5 минут
     */
    public function actionIndex()
    {
        ScoreInput::CheckOnClose();
    }

    public function actionCheck()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.common.models.interest.*');
        Yii::app()->db->createCommand('update score__user_scores set level_id = NULL, full = 0')->execute();

        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $i = 0;
        $users = array(1);

        while (!empty($users)) {
            $criteria->offset = 100 * $i;
            $users = User::model()->with('address', 'interests')->findAll($criteria);

            foreach ($users as $user) {
                if (empty($user->interests)) {
                    $e_criteria = new EMongoCriteria;
                    $e_criteria->addCond('user_id', '==', (int)$user->id);
                    $e_criteria->addCond('action_id', '==', (int)ScoreAction::ACTION_PROFILE_INTERESTS);
                    ScoreInput::model()->deleteAll($e_criteria);
                }

                if (!empty($user->address->country_id))
                    UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_LOCATION);

                if ($user->email_confirmed == 1)
                    UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_EMAIL);

                if (!empty($user->avatar_id))
                    UserScores::checkProfileScores($user->id, ScoreAction::ACTION_PROFILE_PHOTO);
            }

            $i++;
            echo ($i * 100) . "\n";
        }
    }

    public function actionRefreshLevel()
    {
        Yii::import('site.frontend.modules.geo.models.*');
        Yii::import('site.common.models.interest.*');
        Yii::app()->db->createCommand('update score__user_scores set level_id = NULL, full = 0')->execute();
    }

    public function actionEndWeek()
    {
        Yii::import('site.console.components.awards.*');
        Yii::import('site.console.components.awards.community.*');
        Yii::import('site.console.components.awards.community_plus_comments.*');
        Yii::import('site.console.components.awards.community.entities.*');

        BloggerAward::execute(true);
        CommentatorAward::execute(true);
    }

    public function actionEndMonth()
    {
        Yii::import('site.console.components.awards.*');
        Yii::import('site.console.components.awards.community.*');
        Yii::import('site.console.components.awards.entities.*');
        Yii::import('site.console.components.awards.community_plus_comments.*');
        Yii::import('site.console.components.awards.other.*');

        BloggerAward::execute();
        TravellerAward::execute();
        FashionAward::execute();
        MistressAward::execute();
        WeddingAward::execute();
        MasterAward::execute();
        BeautyAward::execute();

        CookAward::execute();
        CommentatorAward::execute();
        PhotoAward::execute();

        JokerAward::execute();
        DoctorAward::execute();
        HouseWifeAward::execute();
        PsychAward::execute();
        ChildrenAward::execute();
        AutoAward::execute();
        PregnancyAward::execute();
        FlowersAward::execute();

        FriendAward::execute();
        DuelAward::execute();
        SmilesAward::execute();
    }

    public function actionUpdateUsers()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $i = 0;
        $models = array(0);
        while (!empty($models)) {
            $models = User::model()->findAll($criteria);
            foreach ($models as $model) {
                echo $model->id . "\n";

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_BLOG);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_BLOG);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_BLOG);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_COMMENTS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_COMMENTS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_COMMENTS);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_FRIENDS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_FRIENDS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_FRIENDS);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_VIDEO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_VIDEO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_VIDEO);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_ALBUMS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_ALBUMS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_ALBUMS);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_DUELS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_DUELS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_DUELS);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_CLUB_POSTS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_CLUB_POSTS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_CLUB_POSTS);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_PHOTO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_PHOTO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_PHOTO);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_YOHOHO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_YOHOHO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_YOHOHO);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_VISITOR);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_VISITOR);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_VISITOR);
            }

            $i++;
            $criteria->offset = $i * 100;
        }
    }

    public function actionUpdateAwards()
    {
        //distribute awards
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = CommunityContent::model()->active()->findAll($criteria);
            foreach ($models as $model) {
                $url = trim($model->url, '.');
                if ($model->id % 1000 == 0)
                    echo $url . "\n";

                //check page views
                $page_views = PageView::model()->findByPath($url);
                if ($page_views !== null)
                    ScoreAward::checkPageViews($model, 0, $page_views->views);

                ScoreAward::checkPageLikes('CommunityContent', $model->id);
            }

            $criteria->offset += 100;
        }

    }

    public function actionEndContest($contest, $show = 1)
    {
        Yii::import('site.frontend.modules.contest.models.*');

        if (!Contest::model()->exists($contest)) {
            echo 'fail';
            return;
        }

        $criteria = new CDbCriteria;
        $criteria->compare('contest_id', $contest);
        $criteria->order = 'rate desc';
        $criteria->limit = 5;
        $works = ContestWork::model()->findAll($criteria);

        if (!$show)
            ScoreInput::model()->add($works[0]->user_id, ScoreInput::TYPE_CONTEST_WIN, array('id' => $contest));
        echo '1: ' . $works[0]->user_id . "\n";
        if (!$show)
            ScoreInput::model()->add($works[1]->user_id, ScoreInput::TYPE_CONTEST_2_PLACE, array('id' => $contest));
        echo '2: ' . $works[1]->user_id . "\n";
        if (!$show)
            ScoreInput::model()->add($works[2]->user_id, ScoreInput::TYPE_CONTEST_3_PLACE, array('id' => $contest));
        echo '3: ' . $works[2]->user_id . "\n";
        if (!$show)
            ScoreInput::model()->add($works[3]->user_id, ScoreInput::TYPE_CONTEST_4_PLACE, array('id' => $contest));
        echo '4: ' . $works[3]->user_id . "\n";
        if (!$show)
            ScoreInput::model()->add($works[4]->user_id, ScoreInput::TYPE_CONTEST_5_PLACE, array('id' => $contest));
        echo '5: ' . $works[4]->user_id . "\n";
    }

    public function actionTest(){
        ScoreInputNewComment::getInstance()->remove(10, 6118);
    }
}

