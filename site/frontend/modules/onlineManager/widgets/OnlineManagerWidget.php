<?php

/**
 * Description of OnlineManagerWidget
 *
 * @author Кирилл
 */
class OnlineManagerWidget extends CWidget
{

	public $view;

	public function run()
	{
		$this->render($this->view);
	}

	/**
	 * 
	 * @param User $user
	 */
	public static function userToJson(User $user)
	{
		return array(
			'id' => $user->id,
			'online' => $user->online,
			'publicChannel' => $user->publicChannel,
		);
	}

}

?>
