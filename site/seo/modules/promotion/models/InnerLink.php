<?php

/**
 * This is the model class for table "inner_linking__links".
 *
 * The followings are the available columns in table 'inner_linking__links':
 * @property string $page_id
 * @property string $phrase_id
 * @property string $page_to_id
 * @property integer $keyword_id
 * @property string $date
 *
 * The followings are the available model relations:
 * @property PagesSearchPhrase $phrase
 * @property Keyword $keyword
 * @property Page $page
 * @property Page $pageTo
 */
class InnerLink extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InnerLink the static model class
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
        return 'inner_linking__links';
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
			array('page_id, page_to_id, keyword_id', 'required'),
			array('keyword_id', 'numerical', 'integerOnly'=>true),
			array('page_id, phrase_id, page_to_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page_id, phrase_id, page_to_id, keyword_id, date', 'safe', 'on'=>'search'),
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
			'phrase' => array(self::BELONGS_TO, 'PagesSearchPhrase', 'phrase_id'),
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
			'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
			'pageTo' => array(self::BELONGS_TO, 'Page', 'page_to_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => 'Page',
			'phrase_id' => 'Phrase',
			'page_to_id' => 'Page To',
			'keyword_id' => 'Keyword',
			'date' => 'Date',
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

		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('phrase_id',$this->phrase_id,true);
		$criteria->compare('page_to_id',$this->page_to_id,true);
		$criteria->compare('keyword_id',$this->keyword_id);
		$criteria->compare('date',$this->date,true);
        $criteria->order = 'date asc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array('pageSize' => 100),
		));
	}

    public function beforeSave()
    {
        $this->date = date("Y-m-d");
        return parent::beforeSave();
    }
}