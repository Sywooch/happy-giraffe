<?php

/**
 * This is the model class for table "antispam__status".
 *
 * The followings are the available columns in table 'antispam__status':
 * @property string $id
 * @property string $user_id
 * @property integer $status
 * @property string $moderator_id
 * @property string $created
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Users $moderator
 */
class AntispamStatus extends HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'antispam__status';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, status', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('user_id, moderator_id', 'length', 'max'=>10),
			array('created, updated', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, status, moderator_id, created, updated', 'safe', 'on'=>'search'),
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
			'moderator' => array(self::BELONGS_TO, 'User', 'moderator_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'status' => 'Status',
			'moderator_id' => 'Moderator',
			'created' => 'Created',
			'updated' => 'Updated',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('moderator_id',$this->moderator_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AntispamStatus the static model class
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
        );
    }

    public function status($status)
    {
        $alias = $this->getTableAlias();

        $this->getDbCriteria()->mergeWith(array(
            'condition' => $alias . '.status = :status',
            'params' => array(':status' => $status),
        ));
        return $this;
    }

    public static function getDp($status)
    {
        return new CActiveDataProvider(self::model()->status($status), array(
            'criteria' => array(
                'order' => 't.id DESC',
                'with' => array('user', 'moderator'),
            ),
        ));
    }

    public function toJson()
    {
        return array(
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => (int) $this->status,
            'updated' => HDate::GetFormattedTime($this->updated),
            'moderator' => $this->moderator === null ? null : array(
                'id' => $this->moderator->id,
                'fullName' => $this->moderator->getFullName(),
                'ava' => $this->moderator->getAvatarUrl(24),
                'online' => (bool) $this->moderator->online,
                'url' => $this->moderator->getUrl(),
            ),
        );
    }
}
