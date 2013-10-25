<?php

/**
 * This is the model class for table "removed".
 *
 * The followings are the available columns in table 'removed':
 * @property string $entity
 * @property integer $entity_id
 * @property integer $user_id
 * @property integer $type
 * @property string $text
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Removed extends HActiveRecord
{
    public static $types = array(
        'Удалено автором',
        'Спам',
        'Оскорбление пользователей',
        'Разжигание межнациональной розни',
        'Другое',
        'Удалено владельцем страницы',
    );

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Removed the static model class
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
		return 'removed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity, entity_id, user_id, type', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('entity', 'length', 'max'=>50),
			array('entity_id, user_id', 'length', 'max'=>10),
            array('text', 'length', 'max' => 100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('entity, entity_id, user_id, type, created', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            )
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'entity' => 'Entity',
			'entity_id' => 'Entity',
			'user_id' => 'User',
			'type' => 'Type',
			'created' => 'Created',
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

		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('entity_id',$this->entity_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterSave()
    {
        $model = call_user_func(array($this->entity, 'model'));
        $object = $model->findByPk($this->entity_id);
        $object->delete();
//        $model->updateByPk($this->entity_id, array('removed' => 1));
        parent::afterSave();
    }

    public function getReason()
    {
        return ($this->type == 4) ? $this->text : self::$types[$this->type];
    }

    /**
     * @param CActiveRecord $entity
     */
    public function restoreByEntity($entity)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('entity', get_class($entity));
        $criteria->compare('entity_id', $entity->getPrimaryKey());
        $model = $this->find($criteria);
        if ($model !== null)
            $model->delete();
    }
}