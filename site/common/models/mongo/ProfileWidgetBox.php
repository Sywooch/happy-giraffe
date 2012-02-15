<?php

class ProfileWidgetBox extends EMongoDocument
{
    public $user_id;
    public $widget_id;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'boxes';
    }

    public function rules()
    {
        return array(
            array('user_id, widget_id', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'user_id' => 'Пользователь',
            'widget_id' => 'Виджет',
        );
    }

    public function widget()
    {
        return ProfileWidget::model()->findByPk(new MongoID($this->widget_id));
    }
}
