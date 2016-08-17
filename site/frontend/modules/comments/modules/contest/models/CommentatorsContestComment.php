<?php
namespace site\frontend\modules\comments\modules\contest\models;

/**
 * @property int $participantId
 * @property int $commentId
 * @property int $points
 *
 * @property \site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant $participant
 * @property \site\frontend\modules\comments\models\Comment $comment
 */
class CommentatorsContestComment extends \HActiveRecord implements \IHToJSON
{
    public function tableName()
    {
        return 'commentators__contests_comments';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CommentatorsContestComment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('points', 'filter', 'filter' => 'intval'),
        );
    }

    public function relations()
    {
        return array(
            'participant' => array(self::BELONGS_TO, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant', 'participantId'),
            'comment' => array(self::BELONGS_TO, 'site\frontend\modules\comments\models\Comment', 'commentId')
        );
    }

    /**
     * @param int $participantId
     *
     * @return CommentatorsContestComment
     */
    public function byParticipant($participantId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.participantId', $participantId);
        return $this;
    }

    /**
     * @param int $userId
     *
     * @return CommentatorsContestComment
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->with[] = 'participant';
        $this->getDbCriteria()->compare('participant.userId', $userId);
        return $this;
    }

    /**
     * @param int $contestId
     *
     * @return CommentatorsContestComment
     */
    public function byContest($contestId)
    {
        $this->getDbCriteria()->with[] = 'participant';
        $this->getDbCriteria()->compare('participant.contestId', $contestId);
        return $this;
    }

    /**
     * @return CommentatorsContestComment
     */
    public function byPoints()
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.points', '> 0');
        return $this;
    }

    /**
     * @param int $commentId
     *
     * @return CommentatorsContestComment
     */
    public function byComment($commentId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.commentId', $commentId);
        return $this;
    }

    /**
     * @return CommentatorsContestComment
     */
    public function orderDesc()
    {
        $c = $this->getDbCriteria();

        if (!isset($c->with['comment'])) {
            $c->with[] = 'comment';
        }

        $this->getDbCriteria()->order = 'comment.created DESC';
        return $this;
    }

    public function toJSON()
    {
        if ($this->comment->commentEntity === null) {
            $entity = null;
        } elseif ($this->comment->commentEntity instanceof \CommunityContent) {
            $entity = array(
                'userId' => $this->comment->commentEntity->author->id,
                'title' => $this->comment->commentEntity->contentTitle,
                'url' => $this->comment->commentEntity->url,
            );
        } else {
            $entity = array(
                'userId' => $this->comment->commentEntity->authorId,
                'title' => $this->comment->commentEntity->title,
                'url' => $this->comment->commentEntity->url,
            );
        }

        return array(
            'comment' => $this->comment->toJSON(),
            'entity' => $entity,
        );
    }
}