<?php
/**
 * @author Никита
 * @date 05/12/14
 */

namespace site\frontend\modules\photo\models\collections;


use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\photo\models\PhotoCollection;

class FamilyPhotoCollection extends PhotoCollection
{
    public function getOwner()
    {
        return FamilyMember::model()->family($this->RelatedModelBehavior->relatedModel->id)->real()->find();
    }
} 