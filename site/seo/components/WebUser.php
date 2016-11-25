<?php
class WebUser extends CWebUser
{
    public $modelName = 'SeoUser';
    /**
     * @var \User
     */
    private $_model = null;

    /**
     * @return \User
     */
    public function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = CActiveRecord::model($this->modelName)->findByPk($this->id);
        }

        return $this->_model;
    }
}