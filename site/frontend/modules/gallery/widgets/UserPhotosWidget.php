<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 8/6/13
 * Time: 10:26 AM
 * To change this template use File | Settings | File Templates.
 */

class UserPhotosWidget extends CWidget
{
    public $userId;

    public function run()
    {
        $collection = new UserPhotoCollection(array('userId' => $this->userId));
        if ($collection->count > 2)
            $this->render('UserPhotosWidget', compact('collection'));
    }
}