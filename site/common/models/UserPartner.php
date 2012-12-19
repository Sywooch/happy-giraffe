<?php

/**
 * This is the model class for table "user__users_partners".
 *
 * The followings are the available columns in table 'user__users_partners':
 * @property string $user_id
 * @property string $name
 * @property string $notice
 *
 * The followings are the available model relations:
 * @property User $user
 * @property AttachPhoto $photos
 * @property int photosCount
 */
class UserPartner extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserPartner the static model class
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
		return 'user__users_partners';
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
			array('user_id', 'length', 'max'=>11),
			array('name', 'length', 'max'=>255),
			array('notice', 'length', 'max'=>1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, name, notice', 'safe', 'on'=>'search'),
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
            'photos' => array(self::HAS_MANY, 'AttachPhoto', 'entity_id', 'with' => 'photo', 'on' => 'photo.removed = 0 AND entity = :modelName', 'params' => array(':modelName' => get_class($this))),
            'photosCount' => array(self::STAT, 'AttachPhoto', 'entity_id', 'condition' => 'entity =: modelName', 'params' => array(':modelName' => get_class($this))),
            'randomPhoto' => array(self::HAS_ONE, 'AttachPhoto', 'entity_id', 'with' => 'photo', 'on' => '`photo`.`removed` = 0 AND entity = :modelName', 'params' => array(':modelName' => get_class($this)), 'order' => new CDbExpression('RAND()')),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'name' => 'Name',
			'notice' => 'Notice',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('notice',$this->notice,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getRandomPhotoUrl()
    {
        if (count($this->photos) == 0)
            return '';

        $i = rand(0, count($this->photos)-1);
        return $this->photos[$i]->photo->getPreviewUrl(180, 180);
    }

    protected function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord) {
            UserAction::model()->add($this->user_id, UserAction::USER_ACTION_FAMILY_UPDATED, array('model' => $this));
            FriendEventManager::add(FriendEvent::TYPE_FAMILY_ADDED, array(
                'entity' => __CLASS__,
                'entity_id' => $this->id,
                'user_id' => $this->user_id,
            ));
        }

        User::model()->UpdateUser($this->user_id);
    }
}