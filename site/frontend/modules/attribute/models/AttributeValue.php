<?php

/**
 * This is the model class for table "{{product_attribute_value}}".
 *
 * The followings are the available columns in table '{{product_attribute_value}}':
 * @property string $value_id
 * @property string $value_value
 */
class AttributeValue extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return AttributeValue the static model class
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
        return 'shop__product_attribute_value';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('value_value', 'required'),
            array('value_value', 'length', 'max' => 150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('value_id, value_value', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'value_id' => 'Value',
            'value_value' => 'Value Value',
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

        $criteria->compare('value_id', $this->value_id, true);
        $criteria->compare('value_value', $this->value_value, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function findOrSave()
    {
        $value_id = Yii::app()->db->createCommand()
            ->select('value_id')
            ->from($this->tableName())
            ->where('value_value=:value_value', array(
            ':value_value' => $this->value_value,
        ))
            ->queryScalar();

        if ($value_id)
            return $value_id;

        if ($this->save())
            return $this->value_id;
    }

    public function beforeSave()
    {
        if($model = $this->findByAttributes(array('value_value' => $this->value_value)))
        {
            $this->primaryKey = $model->primaryKey;
            return false;
        }
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        AttributeValueMap::model()->deleteAll('map_value_id=' . $this->value_id);
        return parent::beforeDelete();
    }
}