<?php

/**
 * This is the model class for table "queries_pages".
 *
 * The followings are the available columns in table 'queries_pages':
 * @property string $id
 * @property string $query_id
 * @property string $page_url
 * @property string $article_id
 * @property integer $yandex_position
 * @property integer $google_position
 *
 * The followings are the available model relations:
 * @property Queries $query
 * @property ArticleKeywords $article
 */
class QueriesPages extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QueriesPages the static model class
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
		return 'queries_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('query_id', 'required'),
			array('yandex_position, google_position', 'numerical', 'integerOnly'=>true),
			array('query_id', 'length', 'max'=>10),
			array('page_url', 'length', 'max'=>1024),
			array('article_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, query_id, page_url, article_id, yandex_position, google_position', 'safe', 'on'=>'search'),
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
			'query' => array(self::BELONGS_TO, 'Queries', 'query_id'),
			'article' => array(self::BELONGS_TO, 'ArticleKeywords', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'query_id' => 'Query',
			'page_url' => 'Page Url',
			'article_id' => 'Article',
			'yandex_position' => 'Yandex Position',
			'google_position' => 'Google Position',
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
		$criteria->compare('query_id',$this->query_id,true);
		$criteria->compare('page_url',$this->page_url,true);
		$criteria->compare('article_id',$this->article_id,true);
		$criteria->compare('yandex_position',$this->yandex_position);
		$criteria->compare('google_position',$this->google_position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}