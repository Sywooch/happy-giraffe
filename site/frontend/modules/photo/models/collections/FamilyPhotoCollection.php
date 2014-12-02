<?php
/**
 * @author Никита
 * @date 11/11/14
 */

namespace site\frontend\modules\photo\models\collections;


use site\frontend\modules\family\models\FamilyMember;
use site\frontend\modules\notifications\models\User;
use site\frontend\modules\photo\components\IPublicPhotoCollection;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class FamilyPhotoCollection extends PhotoCollection implements IPublicPhotoCollection
{
    public function getTitle()
    {
        return 'Семейные фото';
    }

    public function getOwner()
    {
        $family = $this->RelatedModelBehavior->relatedModel;
        $familyMember = FamilyMember::model()->family($family->id)->real()->find();
        return \User::model()->findByPk($familyMember->user->id);
    }
} 