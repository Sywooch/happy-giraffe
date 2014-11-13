<?php
/**
 * @author Никита
 * @date 06/11/14
 */

namespace site\frontend\modules\photo\models\collections;


use site\frontend\modules\photo\components\IPublicPhotoCollection;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class CommunityContentPhotoCollection extends PhotoCollection implements IPublicPhotoCollection
{
    public function getAttachUrl(PhotoAttach $attach)
    {
        return $this->getUrl() . 'photo' . $attach->photo->oldPhoto->id . '/';
    }

    public function getTitle()
    {
        return $this->RelatedModelBehavior->relatedModel->title;
    }
} 