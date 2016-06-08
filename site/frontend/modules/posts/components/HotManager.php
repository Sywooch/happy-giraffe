<?php
/**
 * @author Никита
 * @date 06/06/16
 */

namespace site\frontend\modules\posts\components;


use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\posts\models\Content;

class HotManager
{
    const HOT_THRESHOLD = 5;
    const STATUS_NORMAL = 0;
    const STATUS_HOT = 1;
    const STATUS_WAS_HOT = 2;

    protected $config = [
        7 => 10,
        14 => 7,
        21 => 5,
        28 => 4,
    ];

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
                $attributes['hotStatus'] = self::STATUS_HOT;
            }
            Content::model()->updateAll($attributes, 'originEntityId = :originEntityId', [':originEntityId' => $row['entity_id']]);
        }
    }

    protected function reset()
    {
        Content::model()->updateAll(['hotRate' => 0]);
        Content::model()->updateAll(['hotStatus' => self::STATUS_WAS_HOT], 'hotStatus != :normal', [':normal' => self::STATUS_NORMAL]);
    }

    protected function getRates()
    {
        $criteria = clone Comment::model()->getDbCriteria();
        $criteria->select = $this->getSelectExpression();
        $criteria->addCondition(new \CDbExpression('created > (CURDATE() - INTERVAL :days DAY)'));
        $criteria->params[':days'] = end(array_keys($this->config));
        $criteria->group = 'entity_id';
        $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(Comment::model()->tableName(), $criteria);
        return $command->queryAll();
    }

    protected function getSelectExpression()
    {
        $caseParts = [];
        foreach ($this->config as $days => $score) {
            $caseParts[] = "WHEN DATEDIFF(CURDATE(), created) <= $days THEN $score";
        }
        return new \CDbExpression('`entity_id`, SUM(CASE ' . implode(' ', $caseParts) . ' END) AS rate');
    }
}