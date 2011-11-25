<?php

/**
 * Description of JirafDiscount
 *
 * @author Вячеслав
 */
class JirafDiscount extends IEDiscount
{

	public function apply()
	{
		if(Y::user()->hasState('vaucher'))
		{
			$this->shoppingCart->setDiscountPrice(0);

			$vaucher = Y::user()->getState('vaucher');

			foreach($this->shoppingCart as $position)
			{
				if(!intval($position->product_sell_price))
				{
					$this->shoppingCart->addDiscountPrice(floatval($vaucher['vaucher_discount']) * $position->getSumPrice());
				}
			}

//			$this->shoppingCart->addDiscountPrice($this->shoppingCart->getCost() * floatval($cupon['rate']));
		}
	}

}