<?php
namespace site\frontend\modules\comments\modules\contest\models;

/**
 * @property int $userId
 * @property int $contestId
 * @property int $score
 * @property int $place
 * @property int $dtimeRegister
 *
 * @author Никита
 * @date 20/02/15
 */


class CommentatorsContestParticipant extends \HActiveRecord implements \IHToJSON
{
    public function tableName()
    {
        return 'commentators__contests_participants';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeRegister',
                'updateAttribute' => null,
            ),
        );
    }

    public function contest($contestId)
    {
        $this->getDbCriteria()->compare('t.contestId', $contestId);
        return $this;
    }

    public function user($userId)
    {
        $this->getDbCriteria()->compare('t.userId', $userId);
        return $this;
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, '\User', 'userId'),
            'contest' => array(self::BELONGS_TO, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContest', 'contestId'),
            'comments' => array(self::HAS_MANY, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment', 'commentId'),
        );
    }

    public function top()
    {
        $this->getDbCriteria()->join .= ' LEFT OUTER JOIN newauth__assignments a ON a.itemname = "moderator" AND a.userId = ' . $this->tableAlias . '.userId';
        $this->getDbCriteria()->addCondition('a.itemname IS NULL');
        $this->getDbCriteria()->addCondition($this->tableAlias . '.score != 0');
        $this->getDbCriteria()->order = $this->tableAlias . '.place ASC';
        return $this;
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'userId' => (int) $this->userId,
            'score' => (int) $this->score,
            'place' => (int) $this->place,
        );
    }
}