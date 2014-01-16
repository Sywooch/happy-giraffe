<?php

/**
 * This is the model class for table "antispam__check".
 *
 * The followings are the available columns in table 'antispam__check':
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $created
 * @property string $updated
 * @property integer $status
 * @property string $moderator_id
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property User $moderator
 * @property User $user
 */
class AntispamCheck extends HActiveRecord
{
    const STATUS_UNDEFINED = 0;
    const STATUS_GOOD = 1;
    const STATUS_BAD = 2;
    const STATUS_PENDING = 3;
    const STATUS_QUESTIONABLE = 4;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'antispam__check';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_id, user_id', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('entity', 'length', 'max'=>255),
			array('entity_id', 'length', 'max'=>11),
			array('moderator_id, user_id', 'length', 'max'=>10),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, entity, entity_id, created, updated, status, moderator_id, user_id', 'safe', 'on'=>'search'),
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
			'moderator' => array(self::BELONGS_TO, 'User', 'moderator_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'entity' => 'Entity',
			'entity_id' => 'Entity',
			'created' => 'Created',
			'updated' => 'Updated',
			'status' => 'Status',
			'moderator_id' => 'Moderator',
            'user_id' => 'User',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('entity_id',$this->entity_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('moderator_id',$this->moderator_id,true);
        $criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AntispamCheck the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'RelatedModelBehavior' => array(
                'class' => 'site.common.behaviors.RelatedEntityBehavior',
                'possibleRelations' => array('CommunityContent', 'BlogContent'),
            ),
        );
    }

    public function entity($entity)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'entity = :entity',
            'params' => array(':entity' => $entity),
        ));

        return $this;
    }

    public function status($status)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'status = :status',
            'params' => array(':status' => $status),
        ));

        return $this;
    }

    public function user($userId)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'user_id = :user_id',
            'params' => array(':user_id' => $userId),
        ));

        return $this;
    }

    public static function getLive($entity)
    {
        return self::getDp($entity, self::STATUS_UNDEFINED);
    }

    public function getRemoved($entity)
    {
        return self::getDp($entity, self::STATUS_BAD);
    }

    protected static function getDp($entity, $status)
    {
        return new CActiveDataProvider(self::model()->entity($entity)->status($status), array(
            'criteria' => array(
                'order' => 'id DESC',
            ),
        ));
    }

    public function changeStatus($newStatus)
    {
        if ($this->status == $newStatus)
            return false;

        if ($newStatus == self::STATUS_BAD)
            $this->relatedModel->delete();
        if ($this->status == self::STATUS_BAD)
            $this->relatedModel->restore();
        $this->status = $newStatus;
        $this->moderator_id = Yii::app()->user->id;
        return $this->update(array('status', 'moderator_id', 'updated'));
    }

    public static function changeStatusAll($entity, $userId, $fromStatus, $toStatus)
    {
        $success = true;
        $checks = AntispamCheck::model()->entity($entity)->user($userId)->status($fromStatus)->findAll();
        foreach ($checks as $check)
            $success = $success && $check->changeStatus($toStatus);
        return $success;
    }
}
