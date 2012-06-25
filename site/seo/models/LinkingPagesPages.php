<?php

/**
 * This is the model class for table "linking_pages_pages".
 *
 * The followings are the available columns in table 'linking_pages_pages':
 * @property string $page_id
 * @property string $linkto_page_id
 * @property integer $keyword_id
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 * @property LinkingPages $page
 * @property LinkingPages $linktoPage
 */
class LinkingPagesPages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LinkingPagesPages the static model class
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
        return 'happy_giraffe_seo.linking_pages_pages';
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, linkto_page_id, keyword_id', 'required'),
			array('keyword_id', 'numerical', 'integerOnly'=>true),
			array('page_id, linkto_page_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page_id, linkto_page_id, keyword_id', 'safe', 'on'=>'search'),
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
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
			'page' => array(self::BELONGS_TO, 'LinkingPages', 'page_id'),
			'linktoPage' => array(self::BELONGS_TO, 'LinkingPages', 'linkto_page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => 'Page',
			'linkto_page_id' => 'Linkto Page',
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

		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('linkto_page_id',$this->linkto_page_id,true);
		$criteria->compare('keyword_id',$this->keyword_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}