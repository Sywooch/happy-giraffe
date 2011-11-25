<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class AController extends Controller
{
	public function init()
	{
		Yii::app()->theme = '';
		parent::init();
	}
}