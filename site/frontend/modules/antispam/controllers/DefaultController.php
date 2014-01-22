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
            self::TAB_CHECKS_LIVE => AntispamCheck::model()->count(array('scopes' => 'live')),
            self::TAB_CHECKS_BAD => AntispamCheck::model()->deleted()->count(array('scopes' => 'deleted')),
            self::TAB_CHECKS_QUESTIONABLE => AntispamCheck::model()->questionable()->count(array('scopes' => 'questionable')),
            self::TAB_EXPERT => AntispamReport::model()->status(AntispamReport::STATUS_PENDING)->count(),
            self::TAB_USERS_WHITE => AntispamStatus::model()->status(AntispamStatusManager::STATUS_WHITE)->count(),
            self::TAB_USERS_BLACK => AntispamStatus::model()->status(AntispamStatusManager::STATUS_BLACK)->count(),
            self::TAB_USERS_BLOCKED => AntispamStatus::model()->status(AntispamStatusManager::STATUS_BLOCKED)->count(),
        );
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
            AntispamCheck::ENTITY_POSTS => AntispamCheck::model()->count(array('scopes' => array('entity' => AntispamCheck::ENTITY_POSTS, $scope))),
            AntispamCheck::ENTITY_COMMENTS => AntispamCheck::model()->count(array('scopes' => array('entity' => AntispamCheck::ENTITY_COMMENTS, $scope))),
            AntispamCheck::ENTITY_PHOTOS => AntispamCheck::model()->count(array('scopes' => array('entity' => AntispamCheck::ENTITY_PHOTOS, $scope))),
        );
        $dp = AntispamCheck::getDp(array(
            'scopes' => array(
                'entity' => $entity,
                $scope,
            ),
        ));
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
            AntispamCheck::ENTITY_POSTS => AntispamCheck::model()->count(array('scopes' => array('entity' => AntispamCheck::ENTITY_POSTS, 'user' => $userId))),
            AntispamCheck::ENTITY_COMMENTS => AntispamCheck::model()->count(array('scopes' => array('entity' => AntispamCheck::ENTITY_COMMENTS, 'user' => $userId))),
            AntispamCheck::ENTITY_PHOTOS => AntispamCheck::model()->count(array('scopes' => array('entity' => AntispamCheck::ENTITY_PHOTOS, 'user' => $userId))),
            AntispamCheck::ENTITY_MESSAGES => AntispamCheck::model()->count(array('scopes' => array('entity' => AntispamCheck::ENTITY_MESSAGES, 'user' => $userId))),
        );
        $user = User::model()->with('spamStatus')->findByPk($userId);
        $dp = AntispamCheck::getDp(array(
            'scopes' => array(
                'user' => $userId,
                'entity' => $entity,
            ),
        ));
        $this->render('analysis', compact('user', 'dp', 'counts', 'entity'));
    }
}