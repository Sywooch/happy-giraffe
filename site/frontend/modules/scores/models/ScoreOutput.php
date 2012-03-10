<?php
/**
 * Author: alexk984
 * Date: 10.03.12
 */
class ScoreOutput extends EMongoDocument
{
    const AWARD_TYPE_LEVEL = 1;
    const AWARD_TYPE_ACCESS = 2;

    public $user_id;
    public $award_type = self::AWARD_TYPE_LEVEL;
    public $award_id;
    public $amount = 1;
    public $scores_spent;
    public $created;

    public function getCollectionName()
    {
        return 'score_output';
    }

    public function defaultScope()
    {
        return array(
            'order' => 'created DESC',
        );
    }

    public function beforeSave()
    {
        $this->created = time();
        return parent::beforeSave();
    }
}
