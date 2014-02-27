<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 27/02/14
 * Time: 12:40
 * To change this template use File | Settings | File Templates.
 */

class AvatarUploadForm extends CFormModel
{
    public $image;

    public function rules()
    {
        return array(
            array('image', 'types' => 'jpg, jpeg, gif, png'),
        );
    }
}