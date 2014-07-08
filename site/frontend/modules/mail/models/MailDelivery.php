<?php

/**
 * This is the model class for table "mail__delivery".
 *
 * The followings are the available columns in table 'mail__delivery':
 * @property string $id
 * @property string $user_id
 * @property string $type
 * @property string $sent
 * @property string $clicked
 * @property string $hash
 *
 * The followings are the available model relations:
 * @property User $user
 */
class MailDelivery extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mail__delivery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'length', 'max'=>10),
			array('type', 'length', 'max'=>255),
			array('hash', 'length', 'max'=>32),
			array('sent, clicked', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, type, sent, clicked, hash', 'safe', 'on'=>'search'),
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

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'type' => 'Type',
			'sent' => 'Sent',
			'clicked' => 'Clicked',
			'hash' => 'Hash',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('sent',$this->sent,true);
		$criteria->compare('clicked',$this->clicked,true);
		$criteria->compare('hash',$this->hash,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MailDelivery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function sent()
    {
        $this->sent = new CDbExpression('NOW()');
        $this->update(array('sent'));
    }

    public function clicked()
    {
        $this->clicked = new CDbExpression('NOW()');
        $this->update(array('clicked'));
    }

    public function type($type)
    {
        $this->getDbCriteria()->compare('type', $type);
        return $this;
    }

    public function user($userId)
    {
        $this->getDbCriteria()->compare('user_id', $userId);
        return $this;
    }

    public function getLastDelivery($userId, $type)
    {
        return $this->user($userId)->type($type)->find(array(
            'order' => 'id DESC',
        ));
    }
}
