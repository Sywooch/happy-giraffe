<?php
namespace site\frontend\modules\comments\modules\contest\models;

/**
 * @property int $id
 * @property string $name
 * @property string $cssClass
 */
class CommentatorsContest extends \HActiveRecord
{
    public function tableName()
    {
        return 'commentators__contests';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CommentatorsContest the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'participants' => array(self::HAS_MANY, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant', 'contestId'),
            'participantsCount' => array(self::STAT, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant', 'contestId'),
        );
    }

    /**
     * @return CommentatorsContest
     */
    public function currentActive()
    {
        $this->getDbCriteria()->compare('month', date('mY'));
        return $this;
    }

    public function register($userId)
    {
        if ($this->isRegistered($userId)) {
            return false;
        }

        $participant = new CommentatorsContestParticipant();
        $participant->userId = $userId;
        $participant->contestId = $this->id;
        $participant->place = (int) CommentatorsContestParticipant::model()->contest($this->id)->count() + 1;
        return $participant->save();
    }

    public function isRegistered($userId)
    {
        return CommentatorsContestParticipant::model()->user($userId)->contest($this->id)->find() !== null;
    }

    public function updatePositions()
    {
        /**
         * @var CommentatorsContestParticipant[] $participants
         */
        $participants = CommentatorsContestParticipant::model()->contest($this->id)->findAll(array(
            'order' => 'score DESC',
        ));

        foreach ($participants as $i => $p) {
            $p->place = $i + 1;
            $p->update('place');
        }
    }
}