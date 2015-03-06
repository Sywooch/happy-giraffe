<?php
namespace site\frontend\modules\comments\modules\contest\models;

/**
 * @property int $id
 * @property string $startDate
 * @property string $endDate
 *
 * @author Никита
 * @date 20/02/15
 */

class CommentatorsContest extends \HActiveRecord
{
    public function tableName()
    {
        return 'commentators__contests';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 'NOW() > t.startDate AND NOW() < t.endDate',
            ),
        );
    }

    public function relations()
    {
        return array(
            'participants' => array(self::HAS_MANY, 'site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant', 'contestId'),
        );
    }

    public function register($userId)
    {
        if ($this->isRegistered($userId)) {
            return false;
        }
        $participant = new CommentatorsContestParticipant();
        $participant->userId = $userId;
        $participant->contestId = $this->id;
        $participant->place = CommentatorsContestParticipant::model()->contest($this->id)->count() + 1;
        $participant->save();
    }

    public function isRegistered($userId)
    {
        return CommentatorsContestParticipant::model()->user($userId)->contest($this->id)->find() !== null;
    }

    public function updatePositions()
    {
        $participants = CommentatorsContestParticipant::model()->contest($this->id)->findAll(array(
            'order' => 'score DESC',
        ));
        foreach ($participants as $i => $p) {
            $p->place = $i + 1;
            $p->update('place');
        }
    }
}