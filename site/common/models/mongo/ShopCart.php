<?php
/**
 * @property integer $id
 * @property string $title
 * @property array $cart_attributes
 * @property int $count
 * @property int $price
 * @property int $user_id
 * @property int $is_guest
 */
class ShopCart extends EMongoDocument
{
    public $id;
    public $title;
    public $cart_attributes;
    public $count = 0;
    public $price = 0;
    public $user_id;
    public $is_guest = false;
    public $image;

    public function rules()
    {
        return array(
            array('id, title, cart_attributes, count, price, user_id, is_guest, image', 'safe'),
        );
    }

    public static function add($product, $count)
    {
        if($product instanceof Product)
        {
            $criteria = new EMongoCriteria;
            $criteria->id('==', $product->primaryKey);

            $criteria = self::getUserCriteria($criteria);

            $cart_attributes = null;
            if($product->cart_attributes)
            {
                $cart_attributes = $product->cart_attributes;
                ksort($cart_attributes);
            }
            $criteria->cart_attributes('==', $cart_attributes);

            $model = ShopCart::model()->find($criteria);
        }
        else
        {
            $product = new MongoId($product);
            $model = ShopCart::model()->findByPk($product);
        }

        if(!$model)
        {
            $model = new ShopCart;
            $model->id = $product->primaryKey;
            $model->title = $product->product_title;
            $model->count = $count;
            $model->price = $product->getPrice();
            $model->cart_attributes = $cart_attributes;
            if(Yii::app()->user->isGuest)
            {
                $model->is_guest = true;
                $model->user_id = Yii::app()->session->sessionID;
            }
            else
            {
                $model->user_id = Yii::app()->user->id;
            }
        }
        else
        {
            $model->count += $count;
        }
        $model->save();
        return $model;
    }

    public function getSumPrice()
    {
        return $this->price * $this->count;
    }

    public static function getItemsCount()
    {
        $criteria = self::getUserCriteria();
        $count = 0;
        foreach(ShopCart::model()->findAll($criteria) as $model)
        {
            $count += $model->count;
        }
        return $count;
    }

    public static function getCost()
    {
        $criteria = self::getUserCriteria();
        $price = 0.0;
        foreach(ShopCart::model()->findAll($criteria) as $model)
            $price += $model->price * $model->count;
        return $price;
    }

    public static function getItems()
    {
        $criteria = self::getUserCriteria();
        return ShopCart::model()->findAll($criteria);
    }

    public static function remove($id)
    {
        $id = new MongoId($id);
        $model = ShopCart::model()->deleteByPk($id);
    }

    public static function clear()
    {
        $criteria = self::getUserCriteria();
        return ShopCart::model()->deleteAll($criteria);
    }

    public static function getUserCriteria($criteria = false)
    {
        if(!$criteria)
            $criteria = new EMongoCriteria;
        if(Yii::app()->user->isGuest)
        {
            $criteria->is_guest('==', true);
            $criteria->user_id('==', Yii::app()->session->sessionID);
        }
        else
        {
            $criteria->user_id('==', Yii::app()->user->id);
        }
        return $criteria;
    }

    public static function isEmpty()
    {
        return self::getItemsCount() == 0 ? true : false;
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
