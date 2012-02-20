<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.components.profile.*');

class ProfileCoreWidget extends CPortlet
{
    public $model;
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

    public function init()
    {
        $this->id = $this->model->_id;

        parent::init();
    }

    protected function renderDecoration()
    {
        $this->render('decoration', array(
            'decorationCssClass' => $this->decorationCssClass,
            'titleCssClass' => $this->titleCssClass,
            'title' => $this->title,
            '_id' => $this->model->_id,
        ));
    }

    protected function renderContent()
    {
        $this->render(get_class($this), array(
            'settings' => $this->model->settings,
        ));
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
