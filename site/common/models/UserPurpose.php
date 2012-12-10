<?php

/**
 * This is the model class for table "user__purposes".
 *
 * The followings are the available columns in table 'user__purposes':
 * @property string $id
 * @property string $text
 * @property string $user_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserPurpose extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPurpose the static model class
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
		return 'user__purposes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('text, user_id', 'required'),
            array('user_id', 'exist', 'className' => 'User', 'attributeName' => 'id'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

    public function behaviors(){
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
			'id' => 'ID',
			'text' => 'Текст',
			'user_id' => 'Пользователь',
			'created' => 'Создано',
		);
	}

    protected function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord) {
            UserAction::model()->add($this->user_id, UserAction::USER_ACTION_PURPOSE_CHANGED, array('model' => $this));
            FriendEventManager::add(FriendEvent::TYPE_PURPOSE_UPDATED, array('model' => $this));
        }

        User::model()->UpdateUser($this->user_id);
    }
}