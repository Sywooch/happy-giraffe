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

    public function getCollectionName()
    {
        return 'score_output';
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = time();
        $this->updated = time();
        return parent::beforeSave();
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

    public function inc()
    {
        $this->amount++;
        $this->scores_earned += ScoreActions::getActionInfo($this->action_id)['scores'];
    }
}
