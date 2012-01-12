<?php

/**
 * This is the model class for table "test".
 *
 * The followings are the available columns in table 'test':
 * @property integer $id
 * @property string $name
 * @property string $start_image
 * @property string $css_class
 * @property string $text
 * @property string $slug
 * @property string $result_image
 * @property string $result_title
 * @property string $unknown_result_image
 * @property string $unknown_result_text
 * @property string $yes_no
 *
 * The followings are the available model relations:
 * @property TestQuestion[] $testQuestions
 * @property TestResult[] $testResults
 */
class Test extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Test the static model class
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
		return 'test';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, start_image, slug, result_image, result_title', 'required'),
			array('name, start_image, slug, result_image, result_title, unknown_result_image', 'length', 'max'=>255),
			array('css_class', 'length', 'max'=>20),
			array('text, unknown_result_text, yes_no', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, start_image, css_class, text, slug, result_image, result_title, unknown_result_image, unknown_result_text', 'safe', 'on'=>'search'),
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
			'testQuestions' => array(self::HAS_MANY, 'TestQuestion', 'test_id'),
			'testResults' => array(self::HAS_MANY, 'TestResult', 'test_id'),
            'questionsCount' => array(self::STAT, 'TestQuestion', 'test_id'),
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
			'start_image' => 'Start Image',
			'css_class' => 'Css Class',
			'text' => 'Text',
			'slug' => 'Slug',
			'result_image' => 'Result Image',
			'result_title' => 'Result Title',
			'unknown_result_image' => 'Unknown Result Image',
			'unknown_result_text' => 'Unknown Result Text',
            'yes_no'=>'Yes/No test',
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
		$criteria->compare('start_image',$this->start_image,true);
		$criteria->compare('css_class',$this->css_class,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('result_image',$this->result_image,true);
		$criteria->compare('result_title',$this->result_title,true);
		$criteria->compare('unknown_result_image',$this->unknown_result_image,true);
		$criteria->compare('unknown_result_text',$this->unknown_result_text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Check if results has points
     * @return bool
     */
    public function NoPointResults(){
        foreach ($this->testResults as $res) {
            if (!empty($res->points))
                return false;
        }

        return true;
    }
}