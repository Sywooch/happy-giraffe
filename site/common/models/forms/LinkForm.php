<?php
/**
 * Author: alexk984
 * Date: 31.07.12
 */
class LinkForm extends CFormModel
{
    public $title;
    public $url;

    public function rules()
    {
        return array(
            array('title, url', 'required', 'message'=>'Введите {attribute}'),
            array('title', 'length', 'max' => 100),
            array('url', 'url'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'title'=>'Название ссылки',
            'url'=>'Адресс ссылки'
        );
    }
}