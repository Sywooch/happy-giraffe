<?php

Yii::import('application.profile.*');

class ProfileWidget extends CPortlet
{

    protected $_attributes = array();

    public function init()
    {
        $this->_attributes += array(
            'visibility' => new ProfileSelectAttribute(array(
                'label' => 'Кто может видеть этот виджет?',
                'choices' => array(
                    'all' => 'Всем',
                    'registered' => 'Зарегистрированным',
                    'friends' => 'Друзьям',
                ),
                'default' => 'all',
            )),
            'title' => new ProfileStringAttribute(array(
                ''
            )),
        );
    }
}
