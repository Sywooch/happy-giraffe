<?php

/**
 * This is the model class for table "{{product_image}}".
 *
 * The followings are the available columns in table '{{product_image}}':
 * @property string $image_id
 * @property string $image_product_id
 * @property string $image_file
 * @property string $image_text
 * @property string $image_time
 */
class ProductImage extends CActiveRecord
{
    public $accusativeName = 'изображение';

	public function behaviors()
	{
		return array(
			'behavior_ufiles' => array(
				'class' => 'site.frontend.extensions.ufile.UFileBehavior',
				'fileAttributes'=>array(
					'image_file'=>array(
                        'fileName'=>'upload/product/*/{image_product_id}-<date>-{image_id}.<ext>',
						'fileItems'=>array(
							'product' => array(
								'fileHandler' => array('FileHandler', 'run'),
								'resize' => array(
									'width' => 300,
									'height' => 301,
								),
							),
							'product_thumb' => array(
								'fileHandler' => array('FileHandler', 'run'),
								'product_resize' => array(
									'width' => 76,
									'height' => 79,
								),
							),
							'product_contest' => array(
								'fileHandler' => array('FileHandler', 'run'),
								'product_resize' => array(
									'width' => 127,
									'height' => 132,
								),
							),
							'subproduct' => array(
								'fileHandler' => array('FileHandler', 'run'),
								'product_resize' => array(
									'width' => 200,
									'height' => 160,
								),
							),
							'original' => array(
								'fileHandler' => array('FileHandler', 'run'),
							),
						)
					),
				),
			),
		);
	}

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
		return 'shop__product_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('image_product_id, image_file', 'required'),
			array('image_product_id, image_time', 'length', 'max'=>10),
			array('image_file', 'length', 'max'=>250),
			array('image_text','safe'),
			
			array('image_file', 'site.frontend.extensions.ufile.UFileValidator',
				'allowedTypes'=>'jpg, gif, png, jpeg',
				'allowEmpty'=>false,
			),

			array('image_time', 'default', 'value' => time()),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('image_id, image_product_id, image_file, image_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'image_id' => 'Image',
			'image_product_id' => 'Продукт',
			'image_file' => 'Изображение',
			'image_text' => 'Описание',
			'image_time' => 'Дата',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($crit=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('image_id',$this->image_id);
		$criteria->compare('image_product_id',$this->image_product_id);
		$criteria->compare('image_file',$this->image_file,true);
		$criteria->compare('image_text',$this->image_text,true);
		$criteria->compare('image_time',$this->image_time,true);
		
		if($crit)
			$criteria->mergeWith($crit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}