<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 25/06/14
 * Time: 09:59
 */

namespace site\frontend\modules\photo\models\upload;


class PopupForm extends \CFormModel
{
    public $multiple;

    public function setMultiple($val)
    {
        return ($val === 'true') ? true : false;
    }

    function rules()
    {
        return array(
            array('multiple', 'filter', 'filter' => array($this, 'setMultiple')),
            array('multiple', 'boolean'),
        );
    }

    public function toJSON()
    {
        return \CJSON::encode($this->attributes);
    }
} 