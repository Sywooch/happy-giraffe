<?php

/**
 * This is the model class for table "contest__winners".
 *
 * The followings are the available columns in table 'contest__winners':
 * @property string $id
 * @property integer $place
 * @property string $work_id
 *
 * The followings are the available model relations:
 * @property ContestWork $work
 */
class ContestWinner extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ContestWinner the static model class
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
        return 'contest__winners';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('place, work_id', 'required'),
            array('place', 'numerical', 'integerOnly' => true),
            array('work_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, place, work_id', 'safe', 'on' => 'search'),
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
            'work' => array(self::BELONGS_TO, 'ContestWork', 'work_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'place' => 'Place',
            'work_id' => 'Work',
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
        $criteria->compare('place', $this->place);
        $criteria->compare('work_id', $this->work_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function afterSave()
    {
        if ($this->isNewRecord)
            ScoreInputContestPrize::getInstance()->add($this->work->user_id, $this->work->contest_id, $this->place);

        parent::afterSave();
    }
}