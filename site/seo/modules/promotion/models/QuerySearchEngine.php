<?php

/**
 * This is the model class for table "query_search_engines".
 *
 * The followings are the available columns in table 'query_search_engines':
 * @property integer $id
 * @property integer $query_id
 * @property integer $se_id
 * @property integer $se_page
 * @property string $se_url
 * @property integer $visits
 *
 * The followings are the available model relations:
 * @property Query $query
 */
class QuerySearchEngine extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return QuerySearchEngine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function tableName()
    {
        return 'happy_giraffe_seo.query_search_engines';
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
            array('query_id', 'required'),
            array('query_id, se_id, se_page, visits', 'numerical', 'integerOnly'=>true),
            array('se_url', 'length', 'max'=>1024),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, query_id, se_id, se_page, se_url, visits', 'safe', 'on'=>'search'),
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
			'query' => array(self::BELONGS_TO, 'Query', 'query_id'),
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
			'se_id' => 'Se',
			'se_page' => 'Se Page',
			'se_url' => 'Se Url',
            'visits' => 'Visits',
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
        $criteria->compare('se_id',$this->se_id,true);
        $criteria->compare('se_page',$this->se_page,true);
        $criteria->compare('se_url',$this->se_url,true);
        $criteria->compare('visits',$this->visits);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array('pageSize' => 25),
        ));
    }

    public function getSe()
    {
        if ($this->se_id == 2) return 'yandex';
        if ($this->se_id == 3) return 'google';
        return $this->se_id;
    }
}