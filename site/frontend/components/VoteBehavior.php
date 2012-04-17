<?php

class VoteBehavior extends CActiveRecordBehavior
{
    /**
     * @var array
     */
    public $vote_attributes = null;
    private $_request = null;

    public function getPercent($num)
    {
        $attr = $this->vote_attributes[$num];
        $total = $this->getTotalVotes();
        return $total == 0 ? 0 : round(($this->owner->$attr / $total) * 100);
    }

    public function getTotalVotes()
    {
        $sum = 0;
        foreach ($this->vote_attributes as $attr)
            $sum += $this->owner->$attr;

        return $sum;
    }

    public function vote($user_id, $vote)
    {
        $current_vote = $this->getCurrentVote($user_id);
        $vote_table = $this->owner->tableName() . '_votes';

        $request = $this->GetRequest($user_id);

        if ($current_vote === NULL) {
            Yii::app()->db->createCommand()
                ->insert($vote_table, array(
                'vote' => $vote)+ $request[2]);

            Yii::app()->db->createCommand()
                ->update($this->owner->tableName(), array($this->columnByVote($vote) =>
            new CDbExpression($this->columnByVote($vote) . ' + 1')), 'id = :object_id', array(':object_id' => $this->owner->id));
        }
        elseif ($current_vote != $vote)
        {
            Yii::app()->db->createCommand()
                ->update($vote_table, array('vote' => $vote), $request[0], $request[1]);

            Yii::app()->db->createCommand()
                ->update($this->owner->tableName(), array($this->columnByVote($vote) =>
            new CDbExpression($this->columnByVote($vote) . ' + 1')), 'id = :object_id', array(':object_id' => $this->owner->id));

            Yii::app()->db->createCommand()
                ->update($this->owner->tableName(), array($this->columnByVote($current_vote) =>
            new CDbExpression($this->columnByVote($current_vote) . ' - 1')), 'id = :object_id', array(':object_id' => $this->owner->id));
        }
    }

    protected function columnByVote($vote)
    {
        return $this->vote_attributes[$vote];
    }

    public function getCurrentVote($user_id)
    {
        $vote_table = $this->owner->tableName() . '_votes';

        $request = $this->GetRequest($user_id);
        $vote = Yii::app()->db->createCommand()
            ->select('vote')
            ->from($vote_table)
            ->where($request[0], $request[1])
            ->queryScalar();

        return ($vote === FALSE) ? null : $vote;
    }

    /**
     * @param $user_id
     * @return array
     */
    public function GetRequest($user_id){
        if ($this->_request !== null)
            return $this->_request;

        if (is_array($user_id)) {
            $sql = '';
            $args = array(':object_id' => $this->owner->id);
            $cols = array('object_id' => $this->owner->id);
            foreach ($user_id as $key => $value) {
                $sql .= $key . ' = :' . $key . ' AND ';
                $args[':' . $key] = $value;
                $cols[$key]=$value;
            }
            $sql .= 'object_id = :object_id';
        }
        else {
            $sql = 'object_id = :object_id AND user_id = :user_id';
            $args = array(':object_id' => $this->owner->id, ':user_id' => $user_id);
            $cols = array('object_id' => $this->owner->id, 'user_id' => $user_id);
        }

        $this->_request = array($sql, $args, $cols);
        return $this->_request;
    }
}