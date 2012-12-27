<?php

/**
 * This is the model class for table "search_engines_visits".
 *
 * The followings are the available columns in table 'search_engines_visits':
 * @property string $page_id
 * @property string $month
 * @property integer $count
 *
 * The followings are the available model relations:
 * @property Page $page
 */
class SearchEngineVisits extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SearchEngineVisits the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_seo;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'search_engines_visits';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, month', 'required'),
			array('count', 'numerical', 'integerOnly'=>true),
			array('page_id, month', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('page_id, month, count', 'safe', 'on'=>'search'),
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
			'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'page_id' => 'Page',
			'month' => 'Month',
			'count' => 'Count',
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
		$criteria->compare('month',$this->month,true);
		$criteria->compare('count',$this->count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function addVisit($page_id)
    {
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $exist = self::model()->findByAttributes(array('page_id'=>$page_id,'month'=>date("Y-m")));
            if ($exist === null){
                $exist = new self;
                $exist->page_id = $page_id;
                $exist->month = date("Y-m");
            }

            $exist->count++;
            $exist->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
        }
    }
}