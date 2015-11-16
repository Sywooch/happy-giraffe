<?php
/**
 * @author Никита
 * @date 13/11/15
 */

namespace site\frontend\modules\som\modules\qa\models;


class QaUserRating extends \EMongoDocument
{
    public $answersCount;
    public $questionsCount;
    public $rating;
    public $userId;
    public $period;

    public function getCollectionName()
    {
        return 'qa_user_rating';
    }

    /**
     * This method have to be defined in every model, like with normal CActiveRecord
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}