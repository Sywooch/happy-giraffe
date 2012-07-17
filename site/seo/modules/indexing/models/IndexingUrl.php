<?php

/**
 * This is the model class for table "indexing__urls".
 *
 * The followings are the available columns in table 'indexing__urls':
 * @property string $id
 * @property string $url
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property IndexingUpUrl[] $urls
 */
class IndexingUrl extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IndexingUrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function tableName()
    {
        return 'happy_giraffe_seo.indexing__urls';
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
			array('url', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, active', 'safe', 'on'=>'search'),
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
			'urls' => array(self::HAS_MANY, 'IndexingUpUrl', 'url_id', 'order'=>'url'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
			'active' => 'Active',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getTitle()
    {
        $page = Page::model()->findByAttributes(array('url'=>trim($this->url)));
        if ($page !== null){
            return $page->getArticleTitle();
        }

        return '';
    }
}