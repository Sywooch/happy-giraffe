<?php
/**
 * @property integer $count
 * @property decimal $price
 * @property string $cart_attributes
 */
class ShopCartProduct extends EMongoEmbeddedDocument
{
    public $id;
    public $cart_attributes;
    public $count = 0;
    public $price = 0;

    public function rules()
    {
        return array(
            array('id, count, price, attributes_count', 'numerical'),
        );
    }
}
