<?php

/**
 * This is the model class for table "seo__keyword_groups".
 *
 * The followings are the available columns in table 'seo__keyword_groups':
 * @property string $id
 *
 * The followings are the available model relations:
 * @property ArticleKeywords[] $articleKeywords
 * @property Keywords[] $keywords
 * @property SeoTask[] $seoTasks
 */
class KeywordGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KeywordGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection(){
        return Yii::app()->db_seo;
    }

    public function tableName(){
        return 'happy_giraffe_seo.keyword_groups';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id', 'safe', 'on'=>'search'),
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
			'articleKeywords' => array(self::HAS_MANY, 'ArticleKeywords', 'keyword_group_id'),
			'keywords' => array(self::MANY_MANY, 'Keywords', 'seo__keyword_group_keywords(group_id, keyword_id)'),
			'seoTasks' => array(self::HAS_MANY, 'SeoTask', 'keyword_group_id'),
            'newTasks' => array(self::HAS_MANY, 'SeoTask', 'keyword_group_id', 'condition'=>'status = 0 OR status = 1'),
            'newTaskCount' => array(self::STAT, 'SeoTask', 'keyword_group_id', 'condition'=>'status = 0 OR status = 1'),
		);
	}

    public function behaviors()
    {
        return array(
            'site.frontend.components.ManyToManyBehavior'
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}