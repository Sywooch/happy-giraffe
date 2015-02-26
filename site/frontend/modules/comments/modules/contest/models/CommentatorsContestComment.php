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



class CommentatorsContestComment extends \HActiveRecord
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
            'comment' => array(self::HAS_ONE, 'site\frontend\modules\comments\models\Comment', 'commentId')
        );
    }
}