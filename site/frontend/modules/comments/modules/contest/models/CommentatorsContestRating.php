<?php
/**
 * @author Никита
 * @date 26/02/15
 */

namespace site\frontend\modules\comments\modules\contest\models;


class CommentatorsContestRating extends \HActiveRecord
{
    public function tableName()
    {
        return 'commentators__ratings';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}