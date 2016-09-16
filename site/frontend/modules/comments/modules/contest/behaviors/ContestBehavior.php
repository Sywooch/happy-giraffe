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

    private $isSoftAction = false;

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
        if (\Yii::app()->user->checkAccess('moderator')
            || \Yii::app()->user->checkAccess('advEditor')
            || \Yii::app()->user->checkAccess('editor')
            || in_array(\Yii::app()->user->id, [457198, 175718, 457158, 458713, 15814, 15426, 459499, 436014, 243290, 458733, 208514, 462879, 462875, 462895, 462959, 462943, 463529, 463559, 466068, 15363])) {
            return false;
        }

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
        } else if (!$this->isSoftAction) {
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

            $contestComment->save();

            $this->getParticipant()->score += $contestComment->points;

            $this->getParticipant()->save();
        }
    }

    public function afterSoftDelete()
    {
        if (!$this->init()) {
            return;
        }

        $this->isSoftAction = true;

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
        $contestComment->save();
        $this->getParticipant()->save();
    }

    public function afterSoftRestore()
    {
        if (!$this->init()) {
            return;
        }

        $this->isSoftAction = true;

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

        if ($contestComment->points == 0) {
            $points = $this->getPoints($this->owner);
            $contestComment->points = $points;

            $contestComment->save();

            if ($points) {
                $this->getParticipant()->score += $points;
                $this->getParticipant()->save();
            }
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

        if (array_key_exists('HTTP_APP_ID', $_SERVER) || array_key_exists('HTTP_ACCESS_TOKEN', $_SERVER)) {
            \Yii::app()->params['is_from_device'] = true;
        }

        if ($points != 0 && \Yii::app()->params['is_api_request'] && \Yii::app()->params['is_from_device']) {
            $points *= 2;
        }

        return $points;
    }
}