<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 14/01/14
 * Time: 16:47
 * To change this template use File | Settings | File Templates.
 */

class AntispamBehavior extends CActiveRecordBehavior
{
    public $interval;
    public $maxCount;
    public $safe = false;

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord && ! $this->safe)
            $this->createCheck();
    }

    public function beforeSave($event)
    {
        if ($this->owner->isNewRecord && ! $this->alreadyReported() && $this->limitExceed()) {
            $models = $this->owner->findAll(array(
                'order' => 'id DESC',
                'limit' => $this->maxCount,
            ));

            if ($this->safe)
                foreach ($models as $m)
                    $m->antispam->createCheck();

            $report = new AntispamReportLimit();
            $report->user_id = $this->owner->author_id;
            $report->type = AntispamReport::TYPE_LIMIT;
            $reportData = new AntispamReportLimitData();
            $reportData->entity = get_class($this->owner);
            $reportData->interval = $this->interval;
            $reportData->maxCount = $this->maxCount;
            $reportData->actualInterval = strtotime($models[0]->created) - strtotime($models[$this->maxCount - 1]->created);
            $reportData->ids = CJSON::encode(array_map(function($model) {
                return $model->id;
            }, $models));



            $report->data = $reportData;
            $report->withRelated->save(true, array('data'));
        }
    }

    protected function createCheck()
    {
        try {
            $check = new AntispamCheck();
            $check->entity = get_class($this->owner);
            $check->entity_id = $this->owner->id;
            $check->user_id = $this->owner->author_id;
            $check->save();
        } catch (CDbException $e) {}
    }

    protected function limitExceed()
    {
        $count = $this->owner->count('author_id = :user_id AND created > ' . new CDbExpression('DATE_SUB(NOW(), INTERVAL :interval SECOND)'), array(':user_id' => $this->owner->author_id, ':interval' => $this->interval));
        return $count >= $this->maxCount;
    }

    protected function alreadyReported()
    {
        return AntispamReport::model()->exists('user_id = :user_id AND status = :status', array(':user_id' => $this->owner->author_id, ':status' => AntispamReport::STATUS_PENDING));
    }

    public function attach($owner)
    {
        parent::attach($owner);
        $validators = $owner->getValidatorList();
        $validators->add(CValidator::createValidator('SpamStatusValidator', $owner, 'author_id'));
    }

    public function report()
    {
        $prev = CActiveRecord::model(get_class($this->owner))->findAll(array(
            'limit' => 3,
            'condition' => 't.id < :current_id AND t.author_id = :author_id',
            'params' => array(':current_id' => $this->owner->id, ':author_id' => $this->owner->author_id),
            'order' => 't.id DESC',
        ));

        $next = CActiveRecord::model(get_class($this->owner))->findAll(array(
            'limit' => 3,
            'condition' => 't.id < :current_id AND t.author_id = :author_id',
            'params' => array(':current_id' => $this->owner->id, ':author_id' => $this->owner->author_id),
            'order' => 't.id DESC',
        ));

        $models = CMap::mergeArray(array($this->owner), $prev, $next);
        foreach ($models as $m)
            $m->antispam->createCheck();

        $report = new AntispamReportAbuse();
        $report->user_id = $this->owner->author_id;
        $report->type = AntispamReport::TYPE_ABUSE;
        $reportData = new AntispamReportAbuseData();
        $reportData->entity = get_class($this->owner);
        $reportData->entity_id = $this->owner->id;

        $report->data = $reportData;
        return $report->withRelated->save(true, array('data'));
    }
}