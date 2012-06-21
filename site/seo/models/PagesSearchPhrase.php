<?php

/**
 * This is the model class for table "pages_search_phrases".
 *
 * The followings are the available columns in table 'pages_search_phrases':
 * @property string $id
 * @property string $page_id
 * @property integer $keyword_id
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 * @property Page $page
 * @property SearchPhrasePosition[] $positions
 * @property SearchPhraseVisit[] $visits
 */
class PagesSearchPhrase extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PagesSearchPhrase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    public function tableName()
    {
        return 'happy_giraffe_seo.pages_search_phrases';
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, keyword_id', 'required'),
			array('keyword_id', 'numerical', 'integerOnly'=>true),
			array('page_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, page_id, keyword_id', 'safe', 'on'=>'search'),
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
			'keyword' => array(self::BELONGS_TO, 'Keywords', 'keyword_id'),
			'page' => array(self::BELONGS_TO, 'Pages', 'page_id'),
			'positions' => array(self::HAS_MANY, 'SearchPhrasePosition', 'search_phrase_id'),
			'visits' => array(self::HAS_MANY, 'SearchPhraseVisit', 'search_phrase_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'page_id' => 'Page',
			'keyword_id' => 'Keyword',
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
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('keyword_id',$this->keyword_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}