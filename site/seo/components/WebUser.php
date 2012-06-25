<?php
class WebUser extends CWebUser
{
    public $modelName = 'SeoUser';
    private $_model = null;

    public function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = CActiveRecord::model($this->modelName)->findByPk($this->id);
        }
        return $this->_model;
    }
}