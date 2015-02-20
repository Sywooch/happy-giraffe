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
}