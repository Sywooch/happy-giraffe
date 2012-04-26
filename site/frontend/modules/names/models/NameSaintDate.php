<?php

/**
 * This is the model class for table "name__saint_dates".
 *
 * The followings are the available columns in table 'name__saint_dates':
 * @property string $id
 * @property string $name_id
 * @property string $day
 * @property string $month
 *
 * The followings are the available model relations:
 * @property Name $name
 */
class NameSaintDate extends HActiveRecord
{
    public $accusativeName = 'Дату';

    /**
     * Returns the static model of the specified AR class.
     * @return NameSaintDate the static model class
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
        return 'name__saint_dates';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name_id, day, month', 'required'),
            array('name_id, day, month', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name_id, day, month', 'safe', 'on' => 'search'),
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
            'name' => array(self::BELONGS_TO, 'Name', 'name_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name_id' => 'Имя',
            'day' => 'День',
            'month' => 'Месяц',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name_id', $this->name_id, true);
        $criteria->compare('day', $this->day, true);
        $criteria->compare('month', $this->month, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}