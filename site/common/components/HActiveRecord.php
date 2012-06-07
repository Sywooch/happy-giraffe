<?php
/**
 * Author: choo
 * Date: 25.04.2012
 */
class HActiveRecord extends CActiveRecord
{
    public function getPhotoCollection()
    {
        return $this->photos;
    }
}
