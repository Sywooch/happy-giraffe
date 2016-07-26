<?php
namespace site\frontend\modules\comments\modules\contest\behaviors;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContest;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

/**
 * @property Comment $owner
 * @property CommentatorsContest $currentContest
 * @property CommentatorsContestParticipant $participant
 */
class ContestBehavior extends \CActiveRecordBehavior
{
    const MIN_LENGTH = 40;

    private $currentContest;
    private $participant;

    /**
     * @return CommentatorsContest
     */
    private function getContest()
    {
        if (!$this->currentContest) {
            $this->currentContest = CommentatorsContest::model()
                ->currentActive()
                ->find();
        }

        return $this->currentContest;
    }

    /**
     * @return CommentatorsContestParticipant
     */
    private function getParticipant()
    {
        if (!$this->participant) {
            $this->participant = CommentatorsContestParticipant::model()
                ->user($this->owner->author_id)
                ->contest($this->getContest()->id)
                ->find();
        }

        return $this->participant;
    }

    private function init()
    {
        if (!$this->getContest() ||
            !$this->getParticipant() ||
            !$this->getContest()->register($this->owner->author_id)) {
            return false;
        }

        return true;
    }

    public function events()
    {
        return array_merge(parent::events(), array(
            'onAfterSoftDelete' => 'afterSoftDelete',
            'onAfterSoftRestore' => 'afterSoftRestore',
        ));
    }

    public function afterSave()
    {
        if (!$this->init()) {
            return;
        }
        if ($this->owner->isNewRecord) {
            //CommentatorsContestComment::model()->
        }
    }

    public function afterSoftDelete()
    {

    }

    public function afterSoftRestore()
    {

    }

    /**
     * @param Comment $comment
     *
     * @return int
     */
    private function getPoints($comment)
    {
        $points =  mb_strlen(strip_tags($comment->text), 'UTF-8') >= self::MIN_LENGTH;

        if ($points != 0 && \Yii::app()->params['is_api_request']) {
            $points *= 2;
        }

        return $points;
    }
}