<?php

/**
 * This is the model class for table "test_question".
 *
 * The followings are the available columns in table 'test_question':
 * @property integer $id
 * @property integer $test_id
 * @property string $title
 * @property string $image
 * @property integer $number
 * @property string $text
 *
 * The followings are the available model relations:
 * @property Test $test
 * @property TestQuestionAnswer[] $testQuestionAnswers
 */
class TestQuestion extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return TestQuestion the static model class
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
        return 'test__questions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('test_id, title, number', 'required'),
            array('test_id, number', 'numerical', 'integerOnly' => true),
            array('title, image', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, test_id, title, image, number, text', 'safe', 'on' => 'search'),
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
            'test' => array(self::BELONGS_TO, 'Test', 'test_id'),
            'testQuestionAnswers' => array(self::HAS_MANY, 'TestQuestionAnswer', 'test_question_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'test_id' => 'Test',
            'title' => 'Name',
            'image' => 'Image',
            'number' => 'Number',
            'text' => 'Text',
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
        $criteria->compare('test_id', $this->test_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('number', $this->number);
        $criteria->compare('text', $this->text, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '100',
            )
        ));
    }
}