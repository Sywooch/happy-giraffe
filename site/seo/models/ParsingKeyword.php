<?php

/**
 * This is the model class for table "parsing_keywords".
 *
 * The followings are the available columns in table 'parsing_keywords':
 * @property integer $keyword_id
 * @property integer $depth
 * @property integer $active
 * @property integer $priority
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class ParsingKeyword extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ParsingKeyword the static model class
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
		return 'happy_giraffe_seo.parsing_keywords';
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
			array('keyword_id', 'required'),
			array('keyword_id, active, depth, priority', 'numerical', 'integerOnly'=>true),
			array('priority', 'default', 'value'=>0, 'setOnEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyword_id, active, depth', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'keyword_id' => 'Keyword',
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

		$criteria->compare('keyword_id',$this->keyword_id);
		$criteria->compare('active',$this->active);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function addKeywordById($id)
    {
        $parsing = new ParsingKeyword();
        $parsing->keyword_id = $id;
        try {
            $success = $parsing->save();
            if ($success)
                return true;
        } catch (Exception $e) {

        }

        return false;
    }

    public function addKeywordByIdNotInYandex($id)
    {
        $already = YandexPopularity::model()->findByPk($id);
        if ($already !== null)
            return true;
        return $this->addKeywordById($id);
    }
}