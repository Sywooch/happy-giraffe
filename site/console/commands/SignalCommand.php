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
        Yii::import('site.frontend.modules.signal.helpers.*');
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

    public function loadModerators()
    {
        $this->moderators = Yii::app()->db->createCommand()
            ->select('userid')
            ->from('auth__assignments')
            ->where('itemname = "moderator"')
            ->queryColumn();
    }

    public function actionCommentatorsEndMonth()
    {
        $month = CommentatorsMonth::model()->findByPk(date("Y-m", strtotime('-10 days')));
        $month->calculateMonth();
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

    /**
     * Синхронизировать кол-во заходов из поисковиков с Google Analytics
     */
    public function actionSyncGaVisits()
    {
        CommentatorsMonth::model()->SyncGaVisits();
    }

    /**
     * Синхронизировать кол-во заходов из поисковиков c mysql-базой
     * и пересчитать места и рейтинг комментаторов
     */
    public function actionSync()
    {
        echo "sync\n";
        $month = date("Y-m");
        PageSearchView::model()->sync($month);
        if (date("d") == 1)
            PageSearchView::model()->sync(date("Y-m", strtotime('-2 days')));

        echo "update stats\n";
        $month = CommentatorsMonth::get($month);
        $month->calculateMonth();
    }

    public function actionTest(){
        //echo date("Y-m-d H:i:s", 1356434958);

        $commentator = CommentatorWork::getUser(15426);
        $commentator->calculateDayStats();
    }
}
