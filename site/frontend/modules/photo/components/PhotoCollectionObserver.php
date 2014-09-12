<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 12/09/14
 * Time: 14:47
 */

namespace site\frontend\modules\photo\components;
use site\frontend\modules\photo\models\PhotoCollection;

class PhotoCollectionObserver extends \CComponent implements \ArrayAccess
{
    const COUNT_THRESHOLD = 50;

    protected $model;

    public function __construct(PhotoCollection $model)
    {
        $this->model = $model;
    }

    public function offsetSet($offset, $value)
    {
        $this->model->attaches[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->model->attaches[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->model->attaches[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->model->attaches[$offset];
    }
} 