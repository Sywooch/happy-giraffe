<?php

class DefaultController extends AntispamController
{
    const TAB_CHECKS_LIVE = 0;
    const TAB_EXPERT = 1;
    const TAB_CHECKS_BAD = 2;
    const TAB_CHECKS_QUESTIONABLE = 3;
    const TAB_USERS_WHITE = 4;
    const TAB_USERS_BLACK = 5;
    const TAB_USERS_BLOCKED = 6;

    public $layout = 'antispam';
    public $counts = array();

    public function init()
    {
        $this->counts = array(
            self::TAB_CHECKS_LIVE => AntispamCheck::model()->live()->count(),
            self::TAB_CHECKS_BAD => AntispamCheck::model()->deleted()->count(),
            self::TAB_CHECKS_QUESTIONABLE => AntispamCheck::model()->questionable()->count(),
            self::TAB_EXPERT => AntispamReport::model()->status(AntispamReport::STATUS_PENDING)->count(),
            self::TAB_USERS_WHITE => AntispamStatus::model()->status(AntispamStatusManager::STATUS_WHITE)->count(),
            self::TAB_USERS_BLACK => AntispamStatus::model()->status(AntispamStatusManager::STATUS_BLACK)->count(),
            self::TAB_USERS_BLOCKED => AntispamStatus::model()->status(AntispamStatusManager::STATUS_BLOCKED)->count(),
        );

        parent::init();
    }

    public function actionLive($entity = AntispamCheck::ENTITY_POSTS)
    {
        $this->checks('live', $entity);
    }

    public function actionDeleted($entity = AntispamCheck::ENTITY_POSTS)
    {
        $this->checks('deleted', $entity);
    }

    public function actionQuestionable($entity = AntispamCheck::ENTITY_POSTS)
    {
        $this->checks('questionable', $entity);
    }

    protected function checks($scope, $entity)
    {
        $counts = array(
            AntispamCheck::ENTITY_POSTS => AntispamCheck::model()->$scope()->entity(AntispamCheck::ENTITY_POSTS)->count(),
            AntispamCheck::ENTITY_COMMENTS => AntispamCheck::model()->$scope()->entity(AntispamCheck::ENTITY_COMMENTS)->count(),
            AntispamCheck::ENTITY_PHOTOS => AntispamCheck::model()->$scope()->entity(AntispamCheck::ENTITY_PHOTOS)->count(),
        );
        $dp = AntispamCheck::getDp(AntispamCheck::model()->$scope()->entity($entity));
        $this->render('list', compact('dp', 'status', 'counts'));
    }

    /**
     * Экспертная система
     */
    public function actionExpert()
    {
        $dp = AntispamReport::getDp();
        $this->render('expert', compact('dp'));
    }

    /**
     * Списки пользователей:
     * -белый;
     * -черный;
     * -заблокированные.
     *
     * @param $status
     */
    public function actionUsersList($status)
    {
        $dp = AntispamStatus::getDp($status);
        $this->render('usersList', compact('dp', 'status'));
    }

    /**
     * @param $userId
     * @param $entity
     */
    public function actionAnalysis($userId, $entity = AntispamCheck::ENTITY_POSTS)
    {
        $counts = array(
            AntispamCheck::ENTITY_POSTS => AntispamCheck::model()->entity(AntispamCheck::ENTITY_POSTS)->user($userId)->count(),
            AntispamCheck::ENTITY_COMMENTS => AntispamCheck::model()->entity(AntispamCheck::ENTITY_COMMENTS)->user($userId)->count(),
            AntispamCheck::ENTITY_PHOTOS => AntispamCheck::model()->entity(AntispamCheck::ENTITY_PHOTOS)->user($userId)->count(),
            AntispamCheck::ENTITY_MESSAGES => AntispamCheck::model()->entity(AntispamCheck::ENTITY_MESSAGES)->user($userId)->count(),
        );
        $user = User::model()->with('spamStatus')->findByPk($userId);
        $dp = AntispamCheck::getDp(AntispamCheck::model()->user($userId)->entity($entity));
        $this->render('analysis', compact('user', 'dp', 'counts', 'entity'));
    }

    public function actionStats()
    {
        $tables = array(StatsManager::getLast2WeeksCounts(), StatsManager::getLast2DaysCount());

        $this->render('stats', compact('tables'));
    }
}