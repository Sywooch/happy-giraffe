<?php

/**
 * Виджет, предназначенный для отображения и обновления в реалтайме статуса пользователей
 *
 * @property string $view Представление
 * @property User $user Пользователь (если виджет используется для одного пользователя)
 * @property User[] $users Пользователи (если виджет используется для списка пользователей)
 * @author Кирилл
 */
class OnlineManagerWidget extends CWidget
{

	public $view = null;
	public $user = null;
	public $users = null;
	
	protected static $_basePath;

	public function init()
	{
		if (!is_null($this->user))
		{
			$this->users = array($this->user);
		}
		$this->registerScripts();
	}

	public function run()
	{
		if (!is_null($this->user))
		{
			$this->renderUser();
		}
	}

	/**
	 * Отображение одного пользователя из списка
	 * 
	 * @param mixed $index Индекс пользователя в массиве users
	 * @param string|null $view Ипользуемое представление, если null, то используется $this->view
	 */
	public function renderUser($index = 0, $view = null)
	{
		$view = is_null($view) ? $this->view : $view;
		if (isset($this->users[$index]) && !is_null($view))
		{
			$this->render($view, array('user' => $this->users[$index]));
		}
	}

	/**
	 * 
	 * @param User $user
	 */
	public static function userToJson(User $user)
	{
		return array(
			'id' => $user->id,
			'online' => (int)$user->online,
			'lastOnline' => strtotime($user->last_active),
			'publicChannel' => $user->publicChannel,
		);
	}

	/**
	 * Метод, регистрирующий скрипты, необходимые для работы виджета
	 */
	public function registerScripts()
	{
		/* @var $cs CClientScript */
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('comet');
		$cs->registerCoreScript('knockout');
		$cs->registerCoreScript('ko_onlineManager');
		
	}
	
	/**
	 * Метод, публикующий assets
	 * 
	 * @return string Путь к опубликованным aasets'ам
	 */
	/*public static function getBasePath()
	{
		if (is_null(self::$_basePath))
		{
			self::$_basePath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('site.frontend.modules.onlineManager.assets'), false, -1, YII_DEBUG);
		}
		return self::$_basePath;
	}*/
}

?>
