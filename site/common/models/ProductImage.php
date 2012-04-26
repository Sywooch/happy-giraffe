<?php

/**
 * This is the model class for table "{{product_image}}".
 *
 * The followings are the available columns in table '{{product_image}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $photo_id
 * @property boolean $type
 */
class ProductImage extends HActiveRecord
{
    public $accusativeName = "Изображение";
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shop__product_images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, photo_id, type', 'required'),
			array('product_id, photo_id', 'length', 'max'=>10),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'photo' => array(self::BELONGS_TO, 'AlbumPhoto', 'photo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Image',
			'product_id' => 'Продукт',
			'photo_id' => 'Изображение',
		);
	}
}