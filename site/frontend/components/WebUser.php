<?php
class WebUser extends CWebUser
{
	public $roleAttribute = 'user_role';

	public $modelName = 'User';

	private $_model = null;

	function getRole()
	{
        $roles = Yii::app()->authManager->getRoles($this->id);
        if (!empty($roles))
            return $roles[0];
        return 'user';
	}

	private function getModel()
	{
		if(!$this->isGuest && $this->_model === null)
		{
			$this->_model = CActiveRecord::model($this->modelName)->findByPk($this->id);
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