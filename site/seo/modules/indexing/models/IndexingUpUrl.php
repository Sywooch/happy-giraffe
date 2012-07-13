<?php

/**
 * This is the model class for table "indexing__up_urls".
 *
 * The followings are the available columns in table 'indexing__up_urls':
 * @property string $id
 * @property string $up_id
 * @property string $url_id
 *
 * The followings are the available model relations:
 * @property IndexingUrl $url
 * @property IndexingUp $up
 */
class IndexingUpUrl extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndexingUpUrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function tableName()
    {
        return 'happy_giraffe_seo.indexing__up_urls';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('up_id, url_id', 'required'),
			array('up_id, url_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, up_id, url_id', 'safe', 'on'=>'search'),
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
			'url' => array(self::BELONGS_TO, 'IndexingUrl', 'url_id'),
			'up' => array(self::BELONGS_TO, 'IndexingUp', 'up_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'up_id' => 'Up',
			'url_id' => 'Url',
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
		$criteria->compare('up_id',$this->up_id,true);
		$criteria->compare('url_id',$this->url_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}