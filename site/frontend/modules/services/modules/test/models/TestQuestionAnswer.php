<?php

/**
 * This is the model class for table "test_question_answer".
 *
 * The followings are the available columns in table 'test_question_answer':
 * @property integer $id
 * @property integer $test_question_id
 * @property integer $number
 * @property integer $points
 * @property integer $islast
 * @property string $text
 *
 * The followings are the available model relations:
 * @property TestQuestion $testQuestion
 */
class TestQuestionAnswer extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TestQuestionAnswer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'test__question_answers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('test_question_id, number, text', 'required'),
            array('test_question_id, number, points', 'numerical', 'integerOnly' => true),
            array('text', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, test_question_id, number, points, text', 'safe', 'on' => 'search'),
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
            'testQuestion' => array(self::BELONGS_TO, 'TestQuestion', 'test_question_id'),
            'next_question' => array(self::BELONGS_TO, 'TestQuestion', 'next_question_id'),
            'result' => array(self::BELONGS_TO, 'TestResult', 'result_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'test_question_id' => 'Test Question',
            'number' => 'Number',
            'points' => 'Points',
            'text' => 'Text',
            'islast' => 'islast'
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('test_question_id', $this->test_question_id);
        $criteria->compare('number', $this->number);
        $criteria->compare('points', $this->points);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}