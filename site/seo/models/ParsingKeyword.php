<?php

/**
 * This is the model class for table "parsing_keywords".
 *
 * The followings are the available columns in table 'parsing_keywords':
 * @property integer $keyword_id
 * @property integer $active
 * @property integer $priority
 * @property integer $theme
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
		return 'parsing_keywords';
	}

    public function getDbConnection()
    {
        return Yii::app()->db_keywords;
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
			array('keyword_id, active, priority, theme', 'numerical', 'integerOnly'=>true),
			array('priority', 'default', 'value'=>0, 'setOnEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('keyword_id, active', 'safe', 'on'=>'search'),
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
            'yandex' => array(self::HAS_ONE, 'YandexPopularity', 'keyword_id'),
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

    public static function addNewKeyword($keyword_id, $priority = 0)
    {
        $model = new ParsingKeyword();
        $model->keyword_id = $keyword_id;
        $model->priority = $priority;
        try {
            $success = $model->save();
            if ($success)
                return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function addKeyword($keyword_id, $priority = 0)
    {
        $model = ParsingKeyword::model()->findByPk($keyword_id);
        if ($model === null) {
            $yandex = YandexPopularity::model()->findByPk($keyword_id);
            if ($yandex === null || empty($yandex->parsed)) {
                $model = new ParsingKeyword();
                $model->keyword_id = $keyword_id;
                $model->priority = $priority;
                try {
                    $success = $model->save();
                    if ($success)
                        return true;
                } catch (Exception $e) {

                }
            }
        }else{
            if ($model->priority < $priority){
                $model->priority = $priority;
                $model->update(array('priority'));
            }
        }
        return false;
    }
}