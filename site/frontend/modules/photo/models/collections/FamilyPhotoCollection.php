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
    public function getRelatedCollections()
    {
        return array(
            $this->RelatedModelBehavior->relatedModel->getPhotoCollection('all'),
        );
    }

    public function getAuthor()
    {
        $family = $this->RelatedModelBehavior->relatedModel;
        $familyMember = FamilyMember::model()->family($family->id)->real()->find();
        return \User::model()->findByPk($familyMember->user->id);
    }
} 