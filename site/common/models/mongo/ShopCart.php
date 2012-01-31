<?php
/**
 * @property integer $id
 * @property string $title
 * @property ShopCartProduct $products
 */
class ShopCart extends EMongoDocument
{
    public $title;
    public $products;

    public function rules()
    {
        return array(
            array('title', 'safe'),
        );
    }

    public function behaviors()
    {
        return array(
            array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'products', // name of property
                'arrayDocClassName' => 'ShopCartProduct' // class name of documents in array
            ),
        );
    }

    public static function add(Product $product, $count)
    {
        $criteria = new EMongoCriteria;
        $criteria->_id('==', $product->primaryKey);

        $cart_attributes = null;
        if($product->cart_attributes)
        {
            $cart_attributes = $product->cart_attributes;
            ksort($cart_attributes);
            $criteria->products->cart_attributes('==', $cart_attributes);
        }

        $model = ShopCart::model()->find($criteria);

        if(!$model)
        {
            if(!$model = ShopCart::model()->findByPk($product->primaryKey))
            {
                $model = new ShopCart;
                $model->id = $product->primaryKey;
                $model->title = $product->product_title;
            }
            $products_count = count($model->products) - 1;
            $model->products[$products_count] = new ShopCartProduct;
            $model->products[$products_count]->id = $product->primaryKey;
            $model->products[$products_count]->count = $count;
            $model->products[$products_count]->price = $product->getPrice();
            if($cart_attributes)
            {
                $model->products[$products_count]->cart_attributes = $cart_attributes;
            }
        }
        else
        {
            foreach ($model->products as $m_product)
            {
                if($m_product->cart_attributes == $cart_attributes)
                {
                    $m_product->count += $count;
                    break;
                }
            }

        }
        $model->save();
        return $model;
    }

    public function getCollectionName()
    {
        return 'products';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getId()
    {
        return $this->primaryKey;
    }

    public function setId($value)
    {
        $this->_id = $value;
    }
}
