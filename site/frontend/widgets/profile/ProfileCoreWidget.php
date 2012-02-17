<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.components.profile.*');

class ProfileCoreWidget extends CPortlet
{

    protected $_attributes = array();

    public function __construct($owner = null)
    {
        parent::__construct();

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
                'default' => $this->title,
            )),
        );
    }

    public function getDefaults()
    {
        $defaults = array();
        foreach ($this->_attributes as $name => $a)
        {
            $defaults[$name] = $a->default;
        }
        return $defaults;
    }

    public function showSettingsForm($box)
    {
        $this->render('settings/generic', array(
            'attributes' => $this->_attributes,
            'box' => $box,
        ));
    }
}
