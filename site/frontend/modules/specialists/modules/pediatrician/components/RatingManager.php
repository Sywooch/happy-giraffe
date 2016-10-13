<?php
/**
 * @author Никита
 * @date 13/10/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\components;


use site\frontend\modules\som\modules\qa\models\QaRating;

class RatingManager
{
    public function getRating($limit, $offset = 0)
    {
        $criteria = $this->getCriteria();
        $criteria->limit = $limit;
        $criteria->offset = $offset;
        return QaRating::model()->findAll($criteria);
    }

    protected function getCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'user' => [
                'with' => [
                    'specialistProfile' => [
                        'joinType' => 'INNER JOIN',
                    ],
                ],
            ],
        ];
        $criteria->order = 'total_count DESC';
        return $criteria;
    }
}