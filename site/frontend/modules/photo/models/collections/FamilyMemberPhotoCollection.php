<?php
/**
 * @author Никита
 * @date 11/11/14
 */

namespace site\frontend\modules\photo\models\collections;


use site\frontend\modules\photo\models\PhotoCollection;

class FamilyMemberPhotoCollection extends PhotoCollection
{
    public function getRelatedCollections()
    {
        return array(
            $this->RelatedModelBehavior->relatedModel->family->getPhotoCollection('all'),
        );
    }
} 