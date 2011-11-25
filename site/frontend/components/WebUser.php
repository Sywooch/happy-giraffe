<?php

class WebUser extends CWebUser
{
	public $roleAttribute = 'user_role';

	public $modelName = 'User';

	private $_model = null;

	function getRole()
	{
		if(($user = $this->getModel()))
		{
			// в таблице User есть поле role
			return $user->{$this->roleAttribute};
		}
	}

	private function getModel()
	{
		if(!$this->isGuest && $this->_model === null)
		{
			$this->_model = CActiveRecord::model($this->modelName)->findByPk($this->id, array('select' => $this->roleAttribute));
		}
		return $this->_model;
	}

	/**
	 * @todo put real %
	 * @return float
	 */
	public function getRate()
	{
		return 0.03;
	}
}