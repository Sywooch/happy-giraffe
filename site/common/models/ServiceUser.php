<?php

/**
 * This is the model class for table "services__users".
 *
 * The followings are the available columns in table 'services__users':
 * @property string $user_id
 * @property string $service_id
 * @property string $use_time
 */
class ServiceUser extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ServiceUser the static model class
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
        return 'services__users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, service_id', 'required'),
            array('user_id, service_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, service_id, use_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'service_id' => 'Service',
            'use_time' => 'Use Time',
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

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('service_id', $this->service_id, true);
        $criteria->compare('use_time', $this->use_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        $this->use_time = date("Y-m-d H:i:s");

        return parent::beforeSave();
    }

    public static function addCurrentUser($service_id)
    {
        $model = self::model()->findByAttributes(array(
            'service_id' => $service_id,
            'user_id' => Yii::app()->user->id,
        ));
        if ($model === null) {
            $model = new ServiceUser;
            $model->service_id = $service_id;
            $model->user_id = Yii::app()->user->id;
        }

        $model->save();
    }
}