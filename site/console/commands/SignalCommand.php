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
        Yii::import('site.frontend.modules.messaging.models.*');
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.frontend.modules.cook.models.*');
        Yii::import('site.frontend.modules.friends.models.*');

        return true;
    }

    /**
     * Задать команду пользователя
     * ./yiic signal team --user_id= --team=2
     *
     * @param int $user_id
     * @param int $team
     */
    public function actionTeam($user_id, $team)
    {
        $commentator = CommentatorWork::getUser($user_id);
        $commentator->setTeam($team);
    }

    /**
     * Синхронизировать кол-во заходов из поисковиков c mysql-базой
     * и пересчитать места и рейтинг комментаторов
     */
    public function actionSync()
    {
        $month = date("Y-m");
        $month = CommentatorsMonth::get($month);
        $month->calculateMonth();
    }

    /**
     * Пересчет статистику комментаторов за последние 20 дней
     */
    public function actionRecalc()
    {
        $commentators = CommentatorHelper::getCommentatorIdList();
        foreach ($commentators as $commentator) {
            $model = $this->getCommentator($commentator);
            if ($model) {
                for ($i = 1; $i < 20; $i++) {
                    $date = date("Y-m-d", strtotime('-' . $i . ' days'));
                    $day = $model->getDay($date);
                    if ($day)
                        $day->updatePostsCount($model);
                }
            }
        }
    }

    /**
     * @param int $commentator_id
     * @return CommentatorWork
     */
    public function getCommentator($commentator_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$commentator_id);
        $model = CommentatorWork::model()->find($criteria);
        if ($model === null || $model->isNotWorkingAlready())
            return null;

        return $model;
    }

    public function actionStats()
    {
        $commentators = CommentatorHelper::getCommentatorIdList();
        $result = array_map(function($cId) {
            $user = User::model()->findByPk($cId);
            $commentsCount = CommentatorHelper::commentsCount($cId, '09');
            $goodCommentsCount = CommentatorHelper::commentsCount($cId, '09', true);
            $imStats = CommentatorHelper::imStats($cId, '2013-09-01', '2013-09-30');
            $messagesInCount = $imStats['in'];
            $messagesOutCount = $imStats['out'];
            $blogUniqueVisitors = GApi::model()->uniquePageViews($user->getBlogUrl(), '2013-09-01', '2013-09-30');
            $postsCount = CommentatorHelper::recordsCount($cId, '09');

            return compact('commentsCount', 'goodCommentsCount', 'messagesOutCount', 'messagesInCount', 'blogUniqueVisitors', 'postsCount');
        }, $commentators);

        foreach ($result as $row)
            echo implode(' | ', $row) . "\n";
    }
}
