<?php
/**
 * Class ScoresCommand
 *
 * Модуль "баллы"
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoresCommand extends CConsoleCommand
{
    public function beforeAction()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.modules.scores.models.*');
        Yii::import('site.frontend.modules.scores.models.input.*');
        Yii::import('site.frontend.modules.scores.components.*');
        Yii::import('site.frontend.modules.friends.models.*');
        Yii::import('site.frontend.modules.scores.components.awards.*');
        Yii::import('site.frontend.modules.scores.components.awards.clubs.*');

        return true;
    }

    /**
     * Нужно для объдинения в группы оповещений о набранных баллах. Просматриваем все открытые записи о начислении
     * баллов и если время закрывать, то закрываем. После закрытия оно отобразиться у пользователя
     *
     * Раз в час
     */
    public function actionIndex()
    {
        ScoreInput::getInstance()->CheckClose();
    }

    public function actionEndWeek()
    {
        Yii::import('site.console.components.awards.*');
        Yii::import('site.console.components.awards.community.*');
        Yii::import('site.console.components.awards.community_plus_comments.*');
        Yii::import('site.console.components.awards.community.entities.*');

        BloggerAward::execute(CAward::PERIOD_WEEK);
        CommentatorAward::execute(CAward::PERIOD_WEEK);
    }

    public function actionEndMonth()
    {
        BloggerAward::execute();
        CommentatorAward::execute();
        PhotoAward::execute();

//        TravellerAward::execute();
//        FashionAward::execute();
//        MistressAward::execute();
//        WeddingAward::execute();
//        MasterAward::execute();
//        BeautyAward::execute();
//
//        CookAward::execute();
//
//        JokerAward::execute();
//        DoctorAward::execute();
//        HouseWifeAward::execute();
//        PsychAward::execute();
//        CMotherAward::execute();
//        AutoAward::execute();
//        PregnancyAward::execute();
//        FlowersAward::execute();

        FriendAward::execute();
        SmilesAward::execute();
    }

    public function actionUpdateUsers()
    {
        Yii::import('site.common.models.mongo.*');

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

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_CLUB_POSTS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_CLUB_POSTS);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_CLUB_POSTS);

                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_PHOTO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_PHOTO);
                ScoreAchievement::model()->checkAchieve($model->id, ScoreAchievement::TYPE_PHOTO);
            }

            $i++;
            $criteria->offset = $i * 100;
        }
    }

    /**
     * Проверяем на достижение 100/1000/5000 просмотров клубов. Запускается один раз ночью
     * чтобы исключить проверку на достижение после каждого просмотра страницы
     */
    public function actionClubView()
    {
        UserPostView::getInstance()->checkAchievements();
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

    public function actionContest()
    {
        Yii::import('site.frontend.modules.contest.models.*');
        ScoreInputContestPrize::getInstance()->checkLastContest();
        for ($i = 1; $i < 10; $i++)
            ScoreInputContestPrize::getInstance()->checkContest($i);
    }

    public function actionTest()
    {
        for ($i = 1; $i < 37; $i++) {
            $a = ScoreAchievement::model()->findByPk($i);
            if ($a !== null)
                ScoreInputAchievement::getInstance()->add(10, $a);
        }
    }
}

