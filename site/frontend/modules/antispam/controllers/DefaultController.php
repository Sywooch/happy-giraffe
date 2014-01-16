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
        $check = AntispamCheck::model()->findByPk($checkId);
        $dp = AntispamCheck::getDp($check->spamEntity, null, $check->user_id);
        $this->render('analysis');
    }
}