<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 22/09/14
 * Time: 16:22
 */

namespace site\frontend\modules\photo\models;


class User extends \site\frontend\modules\users\models\User
{
    public function toJSON()
    {
        return array_merge(parent::toJSON(), array(
            'photoCollections' => $this->photoCollections,
        ));
    }
} 