<?php
namespace site\frontend\modules\comments\modules\contest\models;

/**
 * @property int $participantId
 * @property int $commentId
 * @property bool $counts
 *
 * @author Никита
 * @date 25/02/15
 */



class CommentatorsContestComment extends \HActiveRecord implements \IHToJSON
{
    public function tableName()
    {
        return 'commentators__contests_comments';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('counts', 'filter', 'filter' => 'intval'),
        );
    }

    public function relations()
    {
        return array(
            'participant' => array(self::BELONGS_TO, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant', 'participantId'),
            'comment' => array(self::BELONGS_TO, 'site\frontend\modules\comments\models\Comment', 'commentId')
        );
    }

    public function participant($participantId)
    {
        $this->getDbCriteria()->compare('t.participantId', $participantId);
        return $this;
    }

    public function user($userId)
    {
        $this->getDbCriteria()->with[] = 'participant';
        $this->getDbCriteria()->compare('participant.userId', $userId);
        return $this;
    }

    public function contest($contestId)
    {
        $this->getDbCriteria()->with[] = 'participant';
        $this->getDbCriteria()->compare('participant.contestId', $contestId);
        return $this;
    }

    public function counts($counts)
    {
        $this->getDbCriteria()->compare('t.counts', intval($counts));
        return $this;
    }

    public function orderDesc()
    {
        $c = $this->getDbCriteria();

        if (! isset($c->with['comment'])) {
            $c->with[] = 'comment';
        }

        $this->getDbCriteria()->order = 'comment.created DESC';
        return $this;
    }

    public function toJSON()
    {
        return array(
            'comment' => $this->comment->toJSON(),
            'entity' => $this->comment->commentEntity === null ? null : array(
                'userId' => $this->comment->commentEntity->author->id,
                'title' => $this->comment->commentEntity->contentTitle,
                'url' => $this->comment->commentEntity->url,
            ),
        );
    }
}