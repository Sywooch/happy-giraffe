<?php
/**
 * @author Никита
 * @date 24/03/15
 */

namespace site\frontend\modules\pages\widgets\contactFormWidget\models;


class AttachForm extends \CFormModel
{
    public $file;

    public function save()
    {
        $data = \ElasticEmail::uploadAttachment($this->file->getTempName(), $this->file->getName());
        $data['fileName'] = $this->file->getName();
        return $data;
    }
}