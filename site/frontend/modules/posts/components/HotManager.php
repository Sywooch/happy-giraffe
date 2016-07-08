<?php
/**
 * @author Никита
 * @date 06/06/16
 */

namespace site\frontend\modules\posts\components;


use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\posts\behaviors\HotBehavior;
use site\frontend\modules\posts\models\Content;

class HotManager
{
    const HOT_THRESHOLD = 300;
    const COMMENTS_COUNT_MULTIPLIER = 10;
    const VIEWS_COUNT_MULTIPLIER = 1;
    
    public function run()
    {
        $rates = $this->getRates();
        $this->reset();
        $this->setHot($rates);
    }

    protected function isHot($rate)
    {
        return $rate > self::HOT_THRESHOLD;
    }

    protected function setHot($rates)
    {
        foreach ($rates as $row) {
            $attributes = ['hotRate' => $row['rate']];
            if ($this->isHot($row['rate'])) {
                $attributes['hotStatus'] = HotBehavior::STATUS_HOT;
            }
            Content::model()->updateByPk($row['id'], $attributes);
        }
    }

    protected function reset()
    {
        Content::model()->updateAll(['hotRate' => 0]);
        Content::model()->updateAll(['hotStatus' => HotBehavior::STATUS_WAS_HOT], 'hotStatus != :normal', [':normal' => HotBehavior::STATUS_NORMAL]);
    }

    protected function getRates()
    {
        $criteria = Content::model()->getDbCriteria();
        $criteria->select = 't.id, url, COUNT(*) c';
        $criteria->join = 'JOIN comments cm ON cm.new_entity_id = t.id';
        $criteria->group = 't.id';
        $criteria->addCondition('cm.removed = 0');
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
        return array_map(function($row) {
            $views = \Yii::app()->getModule('analytics')->visitsManager->getVisits($row['url']);
            $rate = $row['c'] * self::COMMENTS_COUNT_MULTIPLIER + $views * self::VIEWS_COUNT_MULTIPLIER;
             return [
                'rate' => $rate,
                 'id' => $row['id'],
            ];
        }, $rows);
    }
}