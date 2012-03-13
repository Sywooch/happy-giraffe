<?php
/**
 * Author: alexk984
 * Date: 10.03.12
 */
class ScoreInput extends EMongoDocument
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    public $user_id;
    public $action_id;
    public $amount = 1;
    public $scores_earned;
    public $created;
    public $updated;
    public $status = self::STATUS_OPEN;

    public $added_items = array();
    public $removed_items = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'score_input';
    }

    public function indexes()
    {
        return array(
            'user_id_index' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_DESC,
                ),
                'unique' => false,
            ),
            'created_index' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_DESC,
                    'created' => EMongoCriteria::SORT_DESC,
                ),
                'unique' => false,
            ),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();
        $this->updated = time();

        if ($this->amount == 0) {
            if (!$this->isNewRecord)
                $this->delete();
            return false;
        }
        //check close task or not
        $action_info = ScoreActions::getActionInfo($this->action_id);
        if ($action_info['wait_time'] == 0)
            $this->status = self::STATUS_CLOSED;

        return parent::beforeSave();
    }

    public function defaultScope()
    {
        return array(
            'order' => 'created DESC',
        );
    }

    /**
     * Открытое событие, которое произошло недавно. К нему можно прибавить еще пока оно не закрылось
     *
     * @param $user_id
     * @param $action_id
     * @return ScoreInput
     */
    public function getActiveScoreInput($user_id, $action_id)
    {
        //check can we continue active task
        $action_info = ScoreActions::getActionInfo($action_id);
        if ($action_info['wait_time'] == 0)
            return null;

        $criteria = new EMongoCriteria;
        $criteria->user_id('==', $user_id);
        $criteria->action_id('==', $action_id);
        $criteria->status('==', self::STATUS_OPEN);

        return $this->find($criteria);
    }

    /**
     * @param $score_value
     * @param int $count
     * @param CActiveRecord $entity
     */
    public function addItem($score_value, $count = 1, $entity)
    {
        $this->amount = $this->amount + $count;
        $this->scores_earned += $score_value * $count;
        if ($entity !== null) {
            if (is_array($entity)) {
                $this->added_items [] = array(
                    'id' => (int)$entity['id'],
                    'entity' => $entity['name'],
                );
            } else {
                $this->added_items [] = array(
                    'id' => (int)$entity->primaryKey,
                    'entity' => get_class($entity),
                );
            }
        }
    }

    /**
     * @param $score_value
     * @param int $count
     * @param CActiveRecord $entity
     */
    public function removeItem($score_value, $count = 1, $entity)
    {
        $this->amount = $this->amount - $count;
        $this->scores_earned -= $score_value * $count;
        if ($entity !== null) {
            if (is_array($entity)) {
                $this->removed_items [] = array(
                    'id' => (int)$entity['id'],
                    'entity' => $entity['name'],
                );
            } else {
                foreach ($this->added_items as $key => $added_item) {
                    if ($added_item['id'] == $entity->primaryKey &&
                        $added_item['entity'] == get_class($entity)
                    ) {
                        unset($this->added_items[$key]);
                        return;
                    }
                }
                $this->removed_items [] = array(
                    'id' => (int)$entity->primaryKey,
                    'entity' => get_class($entity),
                );
            }
        }
    }

    /**
     * @static
     * Пользователю отображаются только закрытые события. Проверяем прошло ли время максимальной длительности
     * открытости события
     */
    public static function CheckOnClose()
    {
        $scoreActions = ScoreActions::model()->findAll('wait_time > 0');
        foreach ($scoreActions as $action) {
            $criteria = new EMongoCriteria;
            $criteria->status('==', self::STATUS_OPEN);
            $criteria->action_id('==', (int)$action->id);
            $criteria->created('>', time() + $action->wait_time * 60);

            $modifier = new EMongoModifier();
            $modifier->addModifier('status', 'set', self::STATUS_CLOSED);
            ScoreInput::model()->updateAll($modifier, $criteria);
        }
    }
}
