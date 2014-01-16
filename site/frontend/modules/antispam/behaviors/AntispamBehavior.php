<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 14/01/14
 * Time: 16:47
 * To change this template use File | Settings | File Templates.
 */

Yii::import('site.frontend.modules.antispam.components.*');
Yii::import('site.frontend.modules.antispam.models.*');

class AntispamBehavior extends CActiveRecordBehavior
{
    public $interval;
    public $maxCount;

    public function afterSave($event)
    {
        if ($this->owner->isNewRecord && AntispamStatusManager::getUserStatus($this->owner->author) == AntispamStatusManager::STATUS_UNDEFINED) {
            $check = new AntispamCheck();
            $check->entity = get_class($this->owner);
            $check->entity_id = $this->owner->id;
            $check->user_id = Yii::app()->user->id;
            $check->save();
        }
    }

    public function beforeSave($event)
    {
        if ($this->owner->isNewRecord && ! $this->alreadyReported() && $this->limitExceed()) {
            $report = new AntispamReportLimit();
            $report->user_id = $this->owner->author_id;
            $report->type = AntispamReport::TYPE_LIMIT;
            $reportData = new AntispamReportLimitData();
            $reportData->entity = get_class($this->owner);
            $report->data = $reportData;
            $report->withRelated->save(true, array('data'));
        }
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
}