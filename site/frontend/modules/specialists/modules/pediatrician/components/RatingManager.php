<?php
/**
 * @author Никита
 * @date 13/10/16
 */

namespace site\frontend\modules\specialists\modules\pediatrician\components;

use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaRating;
use User;

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
	    // @ToDo: add condition for banned status
	    //        (antispam__status.user_id = user_id
	    //         and antispam__status.status in (AntispamStatusManager::STATUS_BLACK = 3, AntispamStatusManager::STATUS_BLOCKED = 4)

	    $criteria->addCondition('user.deleted=0 and user.status='.\User::STATUS_ACTIVE);
        $criteria->order = 'total_count DESC';
        return $criteria;
    }
}