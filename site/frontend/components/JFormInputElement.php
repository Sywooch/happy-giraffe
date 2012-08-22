<?php

/**
 * Description of JFormInputElement
 *
 * @author Вячеслав
 */
class JFormInputElement extends CFormInputElement
{
	public function render()
	{
		switch($this->type)
		{
			case 'dropdownlist':
			case 'radiolist':
				return Yii::app()->getController()->renderPartial('application.components.views_old.JForm_radio', array(
					'element' => $this,
				), true);
				break;
			case 'checkboxlist':
				return Yii::app()->getController()->renderPartial('application.components.views_old.JForm_check', array(
					'element' => $this,
				), true);
				break;
			default:
				return parent::render();
				break;
		}
	}
}

