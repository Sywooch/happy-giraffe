<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\photo\models\PhotoCollection;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\Photo;

class PostsAction extends RoutedAction
{
    public function run()
    {
        $this->route('getPhotos', null, null, null);
    }

    public function getPhotos()
    {

    }
}