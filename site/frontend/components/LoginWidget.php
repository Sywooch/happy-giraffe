<?php

class LoginWidget extends CWidget
{
	
	public function run()
	{
		$model = new User;
		$this->render('LoginWidget', array(
			'model' => $model,
		));
	}
	
}