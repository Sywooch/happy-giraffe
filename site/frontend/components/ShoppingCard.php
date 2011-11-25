<?php

/**
 * Description of ShoppingCard
 *
 * @author Вячеслав
 */
class ShoppingCard extends CWidget
{

	public function run()
	{
		if(!Yii::app()->shoppingCart->isEmpty())
		{
			$this->render('ShoppingCard');
		}
	}

}