<?php
/**
 * "Жадный" обозреватель коллекций
 *
 * Загружает все фотографии по отношению, даже если нужна всего одна. Не используется.
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\observers;

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