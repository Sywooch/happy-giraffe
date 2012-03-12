<?php
/**
 * Author: alexk984
 * Date: 10.03.12
 */
class ScoreInput extends EMongoDocument
{
    public $user_id;
    public $action_id;
    public $amount = 1;
    public $scores_earned;
    public $created;
    public $updated;

    public $added_items = array();
    public $removed_items = array();

    public static function model($className=__CLASS__)
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
        return parent::beforeSave();
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->amount == 0 && !$this->isNewRecord)
            $this->delete();
    }

    public function defaultScope()
    {
        return array(
            'order' => 'created DESC',
        );
    }

    /**
     * @param $user_id
     * @return ScoreInput
     */
    public function getLastAction($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', $user_id);

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
        $this->scores_earned += $score_value*$count;
        if ($entity !== null){
            $this->added_items [] = array(
                'id'=>(int)$entity->primaryKey,
                'entity'=>get_class($entity),
            );
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
        $this->scores_earned -= $score_value*$count;
        if ($entity !== null){
            foreach($this->added_items as $key => $added_item){
                if ($added_item['id'] == $entity->primaryKey &&
                    $added_item['entity'] == get_class($entity)){
                    unset($this->added_items[$key]);
                    return ;
                }
            }
            $this->removed_items [] = array(
                'id'=>(int)$entity->primaryKey,
                'entity'=>get_class($entity),
            );
        }
    }
}
