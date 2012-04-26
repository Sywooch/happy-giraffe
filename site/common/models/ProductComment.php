<?php

/**
 * This is the model class for table "shop_product_comment".
 *
 * The followings are the available columns in table 'shop_product_comment':
 * @property string $id
 * @property string $text
 * @property string $created
 * @property string $author_id
 * @property string $product_id
 * @property integer $rating
 */
class ProductComment extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductComment the static model class
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
		return 'shop__product_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('text, author_id, product_id, rating', 'required'),
			array('rating', 'numerical', 'integerOnly'=>true),
			array('author_id, product_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, text, created, author_id, product_id, rating', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'text' => 'Text',
			'created' => 'Created',
			'author_id' => 'Author',
			'product_id' => 'Product',
			'rating' => 'Rating',
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
		$criteria->compare('text',$this->text,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('author_id',$this->author_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('rating',$this->rating);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function get($product_id)
	{
		return $this->findAll(array(
			'condition' => 'product_id=:product_id',
			'params' => array(':product_id' => $product_id),
			'with' => array('author'),
			'order' => 'created DESC',
		));
	}
	
	protected function afterSave()
	{
		$record = $this->find(array(
			'select' => new CDbExpression('AVG(rating) as rating'),
			'condition' => 'product_id=:product_id',
			'params' => array(':product_id' => $this->product_id),
		));
		$new_rating = round($record['rating']);
		Product::model()->updateByPk($this->product_id, array('product_rate' => $new_rating));
	}
	
	/**
	 * Check whether the $authorId has rated
	 * for the $productId.
	 * @param type $authorId
	 * @param type $productId 
	 * @return bool
	 */
	public function isRated($authorId, $productId)
	{
		$command = Yii::app()->db->createCommand();
		$command->select('COUNT(*)')
				->from($this->tableName())
				->where(array(
					'and',
					'author_id = :author_id',
					'product_id = :product_id'
				));
		$command->params = array(
			':author_id' => $authorId, 
			':product_id' => $productId
		);
		return $command->queryScalar() > 0;
	}
}