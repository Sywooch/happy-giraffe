<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 12/09/14
 * Time: 14:47
 */

namespace site\frontend\modules\photo\components\observers;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class PhotoCollectionGreedyObserver extends PhotoCollectionObserver
{
    public function getSingle($offset)
    {
        return $this->model->attaches[$offset];
    }

    public function getSlice($length, $offset)
    {
        return $this->roundSlice($this->model->attaches, $offset, $length);
    }
} 