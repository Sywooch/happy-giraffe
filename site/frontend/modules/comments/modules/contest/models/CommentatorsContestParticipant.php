<?php
namespace site\frontend\modules\comments\modules\contest\models;

/**
 * @property int $id
 * @property int $userId
 * @property int $contestId
 * @property int $score
 * @property int $place
 * @property int $dtimeRegister
 * @property string $settings -> temp field
 *
 * @property \User $user
 */
class CommentatorsContestParticipant extends \HActiveRecord implements \IHToJSON
{
    public function tableName()
    {
        return 'commentators__contests_participants';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CommentatorsContestParticipant the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'CacheDelete' => array(
                'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
            ),
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeRegister',
                'updateAttribute' => null,
            ),
        );
    }

    /**
     * @param int $contestId
     *
     * @return CommentatorsContestParticipant
     */
    public function byContest($contestId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.contestId', $contestId);
        return $this;
    }

    /**
 * @param array $ids
 *
 * @return CommentatorsContestParticipant
 */
    public function byUsers($ids)
    {
        $this->getDbCriteria()->addInCondition($this->getTableAlias() . '.userId', $ids);
        return $this;
    }

    /**
     * @param int $userId
     *
     * @return CommentatorsContestParticipant
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.userId', $userId);
        return $this;
    }

    /**
     * @return CommentatorsContestParticipant
     */
    public function orderByScore()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.score DESC';
        return $this;
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, '\User', 'userId'),
            'contest' => array(self::BELONGS_TO, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContest', 'contestId'),
            'comments' => array(self::HAS_MANY, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContestComment', 'participantId'),
        );
    }

    //----------------------------
    public function top()
    {
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

    public function getSettingArray()
    {
        if (isset($this->settings)) {
            return \CJSON::decode($this->settings, true);
        }

        return null;
    }
}