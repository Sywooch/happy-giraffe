<?php
namespace site\frontend\modules\comments\modules\contest\behaviors;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\comments\modules\contest\components\ContestManager;
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
            $this->currentContest = ContestManager::getCurrentActive();
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
                ->byUser($this->owner->author_id)
                ->byContest($this->getContest()->id)
                ->find();
        }

        return $this->participant;
    }

    private function init()
    {
        if (!$this->getContest() ||
            !$this->getContest()->addParticipant($this->owner->author_id) ||
            !$this->getParticipant()) {
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
            $points = $this->getPoints($this->owner);

            $contestComment = new CommentatorsContestComment();
            $contestComment->commentId = $this->owner->id;
            $contestComment->participantId = $this->getParticipant()->id;;
            $contestComment->points = $points;
            $contestComment->save();

            if ($points) {
                $this->getParticipant()->score += $points;
                $this->getParticipant()->update(array('score'));
            }
        } else {
            /**
             * @var CommentatorsContestComment $contestComment
             */
            $contestComment = CommentatorsContestComment::model()
                ->byComment($this->owner->id)
                ->byParticipant($this->getParticipant()->id)
                ->find();

            if (!$contestComment) {
                return;
            }

            $points = $this->getPoints($this->owner);

            $this->getParticipant()->score -= $contestComment->points;

            $contestComment->points = $points;

            $contestComment->update(array('points'));

            $this->getParticipant()->score += $contestComment->points;

            $this->getParticipant()->update(array('score'));
        }
    }

    public function afterSoftDelete()
    {
        if (!$this->init()) {
            return;
        }

        /**
         * @var CommentatorsContestComment $contestComment
         */
        $contestComment = CommentatorsContestComment::model()
            ->byComment($this->owner->id)
            ->byParticipant($this->getParticipant()->id)
            ->find();

        if (!$contestComment) {
            return;
        }

        if ($contestComment->points) {
            $this->getParticipant()->score -= $contestComment->points;
        }

        $contestComment->points = 0;
        $contestComment->update(array('points'));
        $this->getParticipant()->update(array('score'));
    }

    public function afterSoftRestore()
    {
        if (!$this->init()) {
            return;
        }

        /**
         * @var CommentatorsContestComment $contestComment
         */
        $contestComment = CommentatorsContestComment::model()
            ->byComment($this->owner->id)
            ->byParticipant($this->getParticipant()->id)
            ->find();

        if (!$contestComment) {
            return;
        }

        $points = $this->getPoints($this->owner);
        $contestComment->points = $points;

        $contestComment->update(array('points'));

        if ($points) {
            $this->getParticipant()->score += $points;
            $this->getParticipant()->update(array('score'));
        }
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