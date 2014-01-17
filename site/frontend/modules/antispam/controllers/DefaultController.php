<?php

class DefaultController extends HController
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
    public $activeTab = null;

    public function init()
    {
        $this->counts = array(
            self::TAB_CHECKS_LIVE => AntispamCheck::model()->status(AntispamCheck::STATUS_UNDEFINED)->count(),
            self::TAB_EXPERT => 0,
            self::TAB_CHECKS_BAD => AntispamCheck::model()->status(AntispamCheck::STATUS_BAD)->count(),
            self::TAB_CHECKS_QUESTIONABLE => AntispamCheck::model()->status(AntispamCheck::STATUS_QUESTIONABLE)->count(),
            self::TAB_USERS_WHITE => 0,
            self::TAB_USERS_BLACK => 0,
            self::TAB_USERS_BLOCKED => 0,
        );
    }

    /**
     * Списки карточек:
     * -прямой эфир;
     * -удаленные;
     * -под вопросом.
     *
     * @param $status
     * @param $entity
     */
    public function actionList($status, $entity = AntispamCheck::ENTITY_POSTS)
    {
        $counts = array(
            AntispamCheck::ENTITY_POSTS => AntispamCheck::model()->entity(AntispamCheck::ENTITY_POSTS)->count(),
            AntispamCheck::ENTITY_COMMENTS => AntispamCheck::model()->entity(AntispamCheck::ENTITY_COMMENTS)->count(),
            AntispamCheck::ENTITY_PHOTOS => AntispamCheck::model()->entity(AntispamCheck::ENTITY_PHOTOS)->count(),
        );
        $dp = AntispamCheck::getDp($entity, $status);
        $this->render('list', compact('dp'));
    }

    /**
     * Экспертная система
     */
    public function actionExpert()
    {
        $this->render('expert');
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
        $this->render('usersList');
    }

    /**
     * Страница анализа
     *
     * @param $checkId
     */
//    public function actionAnalysis($userId, )
//    {
//        $user = User::model()->findByPk($userId);
//        $undefinedCount = AntispamCheck::model()->user($userId)->status(AntispamCheck::STATUS_UNDEFINED)->count();
//        $goodCount = AntispamCheck::model()->user($userId)->status(AntispamCheck::STATUS_GOOD)->count();
//        $badCount = AntispamCheck::model()->user($userId)->status(AntispamCheck::STATUS_BAD)->count();
//        $dp = AntispamCheck::getDp($check->spamEntity, null, $userId);
//        $this->render('analysis', compact('dp', 'check', 'undefinedCount', 'goodCount', 'badCount'));
//    }
}