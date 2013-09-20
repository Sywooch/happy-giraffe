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
     * Пересчет статистики комментаторов за последние 20 дней
     */
    public function actionRecalc()
    {
        $commentators = CommentatorHelper::getCommentatorIdList();
        foreach ($commentators as $commentator) {
            $model = $this->getCommentator($commentator);
            if ($model) {
                for ($i = 1; $i < 22; $i++) {
                    $date = date("Y-m-d", strtotime('-' . $i . ' days'));
                    $day = $model->getDay($date);
                    if ($day)
                        $day->updateStatus($model);
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
}
