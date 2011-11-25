<?php

/**
 * Description of JirafFrandsDiscount
 *
 * @author Вячеслав
 */
class JirafFrandsDiscount extends IEDiscount
{

	public function apply()
	{
//		$this->shoppingCart->addDiscountPrice($this->shoppingCart->getCost() * Y::user()->getRate());
		$this->shoppingCart->setDiscountPrice(0);

		foreach($this->shoppingCart as $position)
		{
			if(!intval($position->product_sell_price))
			{
				$this->shoppingCart->addDiscountPrice(Y::user()->getRate() * $position->getSumPrice());
			}
		}
	}

}