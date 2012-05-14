<?php

class LoginForm extends CFormModel
{
	public $username;
	public $password;

	private $_identity;

	public function rules()
	{
		return array(
			array('username, password', 'required'),
			array('password', 'authenticate'),
		);
	}

	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new SeoUserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.');
		}
	}

    public function attributeLabels()
    {
        return array(
            'username'=>'Имя',
            'password'=>'Пароль',
        );
    }

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new SeoUserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===SeoUserIdentity::ERROR_NONE)
		{
			$duration=3600*24*30;
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
