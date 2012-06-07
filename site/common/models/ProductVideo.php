<?php

/**
 * This is the model class for table "shop_product_video".
 *
 * The followings are the available columns in table 'shop_product_video':
 * @property string $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property string $preview
 * @property string $url
 * @property string $product_id
 */
class ProductVideo extends HActiveRecord
{
    public $accusativeName = 'видео';

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductVideo the static model class
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
		return 'shop__product_video';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url', 'url'),
			array('product_id, code, title, description, preview', 'required'),
			array('title, preview', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, title, description, preview', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'title' => 'Title',
			'description' => 'Description',
			'preview' => 'Preview',
			'product_id' => 'Product',
			'url' => 'Url',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('preview',$this->preview,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}