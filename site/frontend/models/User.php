<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $external_id
 * @property string $nick
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $pic_small
 * @property string $link
 * @property string $country
 * @property string $city
 */
class User extends CActiveRecord
{

	public $verifyCode;
	public $current_password;
	public $new_password;
	public $new_password_repeat;

	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			//general
			array('first_name, last_name', 'length', 'max' => 50),
			array('email', 'email'),
			array('password, current_password, new_password, new_password_repeat', 'length', 'min' => 6, 'max' => 12),
			array('gender', 'boolean'),
			array('phone', 'safe'),
			array('settlement_id', 'numerical', 'integerOnly' => true),
		
			//login
			array('email, password', 'required', 'on' => 'login'),
			
			//signup
			array('first_name, email, password, gender', 'required', 'on' => 'signup'),
			array('verifyCode', 'captcha', 'on' => 'signup', 'allowEmpty' => Yii::app()->session->get('service') !== NULL),
			
			//change_password
			array('new_password', 'required', 'on' => 'change_password'),
			array('current_password', 'validatePassword', 'on' => 'change_password'),
			array('new_password_repeat', 'compare', 'on' => 'change_password', 'compareAttribute' => 'new_password'),
			array('verifyCode', 'captcha', 'on' => 'change_password', 'allowEmpty' => false),
		);
	}
	
	public function validatePassword($attribute, $params)
	{
		if ($this->password !== $this->hashPassword($this->current_password)) $this->addError('password', 'Текущий пароль введён неверно.');

	}

	public function checkUserPassword($attribute,$params)
	{
		$userModel = $this->find(array('condition' => 'email="'.$this->email.'" AND password="'.$this->hashPassword($this->password).'"'));
		if (!$userModel)
		{
			$this->addError($attribute, 'Не найден пользователь с таким именем и паролем');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'babies' => array(self::HAS_MANY, 'Baby', 'parent_id'),
			'social_services' => array(self::HAS_MANY, 'UserSocialService', 'user_id'),
			'settlement'=> array(self::BELONGS_TO, 'GeoRusSettlement', 'settlement_id'),
			'communities' => array(self::MANY_MANY, 'User', 'user_via_community(user_id, community_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'first_name' => 'Имя',
			'email' => 'E-mail',
			'password' => 'Пароль',
			'gender' => 'Пол',
			'phone' => 'Телефон',
			'current_password' => 'Текущий пароль',
			'new_password' => 'Новый пароль',
			'new_password_repeat' => 'Новый пароль ещё раз',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('external_id',$this->external_id);
		$criteria->compare('nick',$this->nick,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('pic_small',$this->pic_small,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord OR $this->scenario == 'change_password')
			{
				$this->password = $this->hashPassword($this->password);
			}
			return true;
		}
		else
			return false;
	}
	
	protected function afterSave()
	{
		parent::afterSave();
		
		foreach ($this->social_services as $service)
		{
			$service->user_id = $this->id;
			$service->save();
		}
	}

	public function hashPassword($password)
    {
        return md5($password);
    }
    
	public function behaviors(){
		return array(
			'behavior_ufiles' => array(
				'class' => 'ext.ufile.UFileBehavior',
				'fileAttributes'=>array(
					'pic_small'=>array(
						'fileName'=>'upload/avatars/*/<date>-{id}-<name>.<ext>',
						'fileItems'=>array(
							'ava' => array(
								'fileHandler' => array('FileHandler', 'run'),
								'accurate_resize' => array(
									'width' => 76,
									'height' => 79,
								),
							),
							'original' => array(
								'fileHandler' => array('FileHandler', 'run'),
							),
						)
					),
				),
			),
//			'attribute_set' => array(
//				'class'=>'attribute.AttributeSetBehavior',
//				'table'=>'shop_product_attribute_set',
//				'attribute'=>'product_attribute_set_id',
//			),
			'getUrl' => array(
				'class' => 'ext.geturl.EGetUrlBehavior',
				'route' => 'product/view',
				'dataField' => array(
					'id' => 'product_id',
					'title' => 'product_slug',
				),
			),
			'statuses' => array(
				'class' => 'ext.status.EStatusBehavior',
				// Поле зарезервированное для статуса
				'statusField' => 'product_status',
				'statuses' => array(
					0 => 'deleted',
					1 => 'published',
					2 => 'view only',
				),
			),
			'ESaveRelatedBehavior' => array(
				'class' => 'ESaveRelatedBehavior'
			), 
		);
	}
	
	public function hasCommunity($id)
	{
		foreach ($this->communities as $c)
		{
			if ($c->id == $id) return TRUE;
		}
		return FALSE;
	}

	/**
     * @static
     * @return User
     */
    public static function GetCurrentUser(){
        $user = User::model()->with(array('babies'))->findByPk(Yii::app()->user->getId());
        return $user;
    }
}