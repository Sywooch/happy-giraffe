<?php

namespace site\frontend\modules\som\modules\activity\models;

/**
 * This is the model class for table "som__activity".
 *
 * The followings are the available columns in table 'som__activity':
 * @property string $id
 * @property string $userId
 * @property string $typeId
 * @property string $dtimeCreate
 * @property string $data
 * @property array $dataArray
 *
 * The followings are the available model relations:
 * @property ActivityType $type
 * @property Users $user
 */
class Activity extends \CActiveRecord implements \IHToJSON
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'som__activity';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userId, typeId, dtimeCreate, data', 'required'),
            array('id, typeId', 'length', 'max' => 20),
            array('userId, dtimeCreate', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, userId, typeId, dtimeCreate, data', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => null,
                'publicationAttribute' => null,
                'owerwriteAttributeIfSet' => false,
            ),
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
            'type' => array(self::BELONGS_TO, 'ActivityType', 'typeId'),
            'user' => array(self::BELONGS_TO, 'Users', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'userId' => 'User',
            'typeId' => 'Type',
            'dtimeCreate' => 'Dtime Create',
            'data' => 'Data',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('typeId', $this->typeId, true);
        $criteria->compare('dtimeCreate', $this->dtimeCreate, true);
        $criteria->compare('data', $this->data, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getDataArray()
    {
        return \CJSON::decode($this->data);
    }

    public function setDataArray($value)
    {
        $this->data = \CJSON::encode($value);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Activity the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'userId' => (int) $this->userId,
            'typeId' => $this->typeId,
            'dtimeCreate' => (int) $this->dtimeCreate,
            'data' => $this->dataArray,
        );
    }

    /* scopes */

    public function defaultScope()
    {
        return array(
            'order' => $this->getTableAlias(false, false) . '.`dtimeCreate` DESC',
        );
    }

    public function byUser($userId)
    {
        $this->getDbCriteria()->addColumnCondition(array('userId' => $userId));

        return $this;
    }

}
