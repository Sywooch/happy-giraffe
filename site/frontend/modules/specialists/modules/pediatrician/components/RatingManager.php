<?php
/**
 * @author Никита
 * @date 13/10/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\components;


use site\frontend\modules\som\modules\qa\models\QaCategory;
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
    
    public function getCount()
    {
        return QaRating::model()->count($this->getCriteria());
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
        $criteria->compare('category_id', QaCategory::PEDIATRICIAN_ID);
        $criteria->order = 'total_count DESC';
        return $criteria;
    }
}