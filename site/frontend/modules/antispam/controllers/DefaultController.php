<?php

class DefaultController extends HController
{
    public $layout = 'antispam';

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
    public function actionAnalysis($checkId)
    {
        $check = AntispamCheck::model()->with('user, user.spamStatus')->findByPk($checkId);
        $undefinedCount = AntispamCheck::model()->user($check->user_id)->status(AntispamCheck::STATUS_UNDEFINED)->count();
        $goodCount = AntispamCheck::model()->user($check->user_id)->status(AntispamCheck::STATUS_GOOD)->count();
        $badCount = AntispamCheck::model()->user($check->user_id)->status(AntispamCheck::STATUS_BAD)->count();
        $dp = AntispamCheck::getDp($check->spamEntity, null, $check->user_id);
        $this->render('analysis', compact('dp', 'check', 'undefinedCount', 'goodCount', 'badCount'));
    }
}