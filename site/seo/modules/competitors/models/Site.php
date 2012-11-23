<?php

/**
 * This is the model class for table "sites__sites".
 *
 * The followings are the available columns in table 'sites__sites':
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property int $section
 *
 * The followings are the available model relations:
 * @property SiteKeywordVisit[] $seoKeyStats
 */
class Site extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Site the static model class
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
		return 'sites__sites';
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
			array('name', 'required'),
			array('name, url', 'length', 'max'=>255),
            array('section', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, url', 'safe', 'on'=>'search'),
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
			'seoKeyStats' => array(self::HAS_MANY, 'SiteKeywordVisit', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return int[]
     */
    public function getGroupSiteIds()
    {
        $sites = Yii::app()->db_seo->createCommand()
                    ->select('site_id')
                    ->from('sites__group_sites')
                    ->where('group_id = '.$this->id)
                    ->queryColumn();
        if (!empty($sites))
            return $sites;
        else
            return array($this->id);
    }
}