<?php

class ProfileWidgetBox extends EMongoDocument
{
    public $user_id;
    public $widget_id;
    public $settings;
    public $position_x;
    public $position_y;

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
            array('user_id, widget_id, settings, position_x, position_y', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'user_id' => 'Пользователь',
            'widget_id' => 'Виджет',
            'settings' => 'Настройки',
            'position_x' => 'Столбец',
            'position_y' => 'Строка',
        );
    }

    public function widget()
    {
        return ProfileWidget::model()->findByPk(new MongoID($this->widget_id));
    }
}