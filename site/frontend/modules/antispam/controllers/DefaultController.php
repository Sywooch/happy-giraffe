<?php

class DefaultController extends HController
{
    public $layout = 'antispam';
    public $counters = array();

    public function init()
    {
        $this->counters = array(
            AntispamCheck::model()->status(AntispamCheck::STATUS_UNDEFINED)->count(),
            0,
            0,
            0,
            0,
            0,
            0,
        );
    }

    /**
     * Прямой эфир
     *
     * @param $entity
     */
    public function actionLive($entity = AntispamCheck::ENTITY_POSTS)
    {
        $dp = AntispamCheck::getDp($entity, AntispamCheck::STATUS_UNDEFINED);
        $this->render('list', compact('dp'));
    }

    public function actionDeleted($entity = AntispamCheck::ENTITY_POSTS)
    {
        $dp = AntispamCheck::getDp($entity, AntispamCheck::STATUS_BAD);
        $this->render('list', compact('dp'));
    }

    public function actionQuestionable($entity = AntispamCheck::ENTITY_POSTS)
    {
        $dp = AntispamCheck::getDp($entity, AntispamCheck::STATUS_QUESTIONABLE);
        $this->render('list', compact('dp'));
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