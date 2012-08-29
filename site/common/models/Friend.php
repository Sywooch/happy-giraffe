<?php

/**
 * This is the model class for table "friends".
 *
 * The followings are the available columns in table 'friends':
 * @property string $id
 * @property string $user1_id
 * @property string $user2_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $user2
 * @property User $user1
 */
class Friend extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Friend the static model class
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
		return 'friends';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('user1_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
            array('user2_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'user1' => array(self::BELONGS_TO, 'User', 'user1_id'),
			'user2' => array(self::BELONGS_TO, 'User', 'user2_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user1_id' => 'Пользователь 1',
			'user2_id' => 'Пользователь 2',
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
}