<?php
throw new Exception('Виджет устарел, необходимо использовать requireJS');
/**
 * Виджет для написания быстрых сообщений
 *
 * Примеры использования:
 * <ul>
 *	<li>
 *		Использование в html:
 *		<p><code>
 *			<a href="#" data-fast-message-for="1234">Отправить быстрое сообщение пользователю с id=1234</a>
 *		</code></p>
 *		При этом в php необходимо подключить данный виджет (messaging.widgets.fastMessageWidget.FastMessageWidget),
 *		он подключит необходимые скрипты и отрендерит форму для отправки сообщений. При повторном подключении
 *		ничего не произойдет.
 *	</li>
 *	<li>
 *		Использование в php:
 *		<p><code>
 *			$this->widget('messaging.widgets.fastMessageWidget.FastMessageWidget');
 *			echo CHtml::link("Отправить быстрое сообщение пользователю с id=1234", "#", FastMessageWidget::addDataAttribute(1234, array('class'=>'button')));
 *		</code></p>
 *	</li>
 *	<li>
 *		Использование с knockout:
 *		<p><code>
 *			<a href="#" data-bind="attr: {'data-fast-message-for' : id}">Быстрое сообщение</a>
 *		</code></p>
 *		При этом в php необходимо подключить данный виджет (messaging.widgets.fastMessageWidget.FastMessageWidget),
 *		он подключит необходимые скрипты и отрендерит форму для отправки сообщений. При повторном подключении
 *		ничего не произойдет.
 *	</li>
 * </ul>
 * 
 * @author Кирилл
 */
class FastMessageWidget extends CWidget
{

	public $view = 'default';

	public function run()
	{
		$this->registerScripts();
	}

	public static function addDataAttribute($user, $attributes = array())
	{
		if ($user instanceof User)
		{
			$user = $user->id;
		}
		if ($user)
		{
			$attributes['data-fast-message-for'] = (int) $user;
		}

		return $attributes;
	}

	public function registerScripts()
	{
		/* @var $cs ClientScript */
        $cs = Yii::app()->clientScript;
        if($cs->useAMD)
        {
            $cs->registerAMD('FastMessageWidget', 'ko_im', $this->initScript);
        }
        else
        {
            $cs->registerPackage('ko_im');
            $cs->registerScript('FastMessageWidget', $this->initScript, CClientScript::POS_LOAD);
        }
	}

	public function getInitScript()
	{
		return '$(' . CJSON::encode($this->render($this->view, array(), true)) . ').hide().appendTo("body");';
	}

}

?>
