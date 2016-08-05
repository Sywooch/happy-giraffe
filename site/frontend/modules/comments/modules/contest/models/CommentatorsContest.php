<?php
namespace site\frontend\modules\comments\modules\contest\models;

/**
 * @property int $id
 * @property string $name
 * @property string $cssClass
 * @property string $month
 */
class CommentatorsContest extends \HActiveRecord
{
    private static $monthNames = array(
        '01' => 'Январь',
        '02' => 'Февраль',
        '03' => 'Март',
        '04' => 'Апрель',
        '05' => 'Май',
        '06' => 'Июнь',
        '07' => 'Июль',
        '08' => 'Август',
        '09' => 'Сентябрь',
        '10' => 'Октябрь',
        '11' => 'Ноябрь',
        '12' => 'Декабрь',
    );

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

    public function addParticipant($userId)
    {
        if ($this->isParticipant($userId)) {
            return true;
        }

        $participant = new CommentatorsContestParticipant();
        $participant->userId = $userId;
        $participant->contestId = $this->id;
        $participant->place = (int) CommentatorsContestParticipant::model()->byContest($this->id)->count() + 1;
        return $participant->save();
    }

    public function isParticipant($userId)
    {
        return CommentatorsContestParticipant::model()->byUser($userId)->byContest($this->id)->find() !== null;
    }

    public function updatePositions()
    {
        /**
         * @var CommentatorsContestParticipant[] $participants
         */
        $participants = CommentatorsContestParticipant::model()->byContest($this->id)->findAll(array(
            'order' => 'score DESC',
        ));

        foreach ($participants as $i => $p) {
            $p->place = $i + 1;
            $p->update('place');
        }
    }

    public function getFullMonth()
    {
        $month = mb_substr($this->month, 0, 2);
        $year = mb_substr($this->month, 2);

        return self::$monthNames[$month] . ' ' . $year;
    }
}