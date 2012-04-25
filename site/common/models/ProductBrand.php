<?php

/**
 * This is the model class for table "{{product_brand}}".
 *
 * The followings are the available columns in table '{{product_brand}}':
 * @property string $brand_id
 * @property string $brand_title
 * @property string $brand_text
 * @property string $brand_image
 */
class ProductBrand extends HActiveRecord {

    public function getProductsCount()
    {
        return Product::model()->count('product_brand_id='.$this->brand_id.' AND product_status=1');
    }

    public $accusativeName = 'брэнд';

	public function behaviors() {
		return array(
			'behavior_ufiles' => array(
				'class' => 'site.frontend.extensions.ufile.UFileBehavior',
				'fileAttributes' => array(
					'brand_image' => array(
						'fileName' => 'upload/brand/*/<date>-{brand_id}-<name>.<ext>',
						'fileItems' => array(
                            'display' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                                'resize' => array(
                                    'width' => 100,
                                    'height' => 50,
                                ),
                            ),
                            'original' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                            ),
						),
					),
				),
			),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductBrand the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'shop__product_brand';
	}
	
	public function primaryKey() {
		return 'brand_id';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('active', 'default', 'value' => 1),
            array('active', 'boolean'),
			array('brand_title, brand_image', 'required'),
			array('brand_title', 'length', 'max' => 250),
			array('brand_text', 'safe'),
			array('brand_image', 'site.frontend.extensions.ufile.UFileValidator',
				'allowedTypes' => 'jpg, gif, png',
//				'minWidth'=>621, 'minHeight'=>424,
				'allowEmpty' => true
			),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('brand_id, brand_title, brand_text, brand_image', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'brand_id' => 'Brand',
			'brand_title' => 'Наименование',
			'brand_text' => 'Описание',
			'brand_image' => 'Изображение',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('brand_id', $this->brand_id);
		$criteria->compare('brand_title', $this->brand_title, true);
		$criteria->compare('brand_text', $this->brand_text, true);
//		$criteria->compare('brand_image',$this->brand_image,true);

		return new CActiveDataProvider($this, array(
					'criteria' => $criteria,
				));
	}

    public function uploadTo(){
        return 'upload/brand/';
    }

    public function GetImageUrl(){
        return $this->brand_image;
    }

	public function listAll($term='', $val='brand_title') {
		if (!is_array($val)) {
			$val = explode(',', $val);

			foreach ($val as $k => $v) {
				if (($v = trim($v)))
					$val[$k] = $v;
				else
					unset($val[$k]);
			}
		}

		if (!$val)
			return array();

		$command = Y::command()
				->select(array_merge($val, array('brand_id')))
				->from($this->tableName());

		if ($term && is_string($term)) {
			$command->where(array('like', 'brand_title', "%$term%"));
		}

		return $command->queryAll();
	}

    public function getAll($query) {
        $criteria = new CDbCriteria(array(
            'order' => 'brand_id',
        ));
        if ($query !== null)
        {
            $criteria->mergeWith(array(
                'condition' => 'brand_title LIKE :query',
                'params' => array(
                    ':query' => $query . '%',
                ),
            ));
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }
}