<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $external_id
 * @property string $vk_id
 * @property string $nick
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $pic_small
 * @property string $role
 * @property string $link
 * @property string $country
 * @property string $city
 * @property int $deleted
 * @property integer $gender
 * @property string $birthday
 * @property string $settlement_id
 * @property string $mail_id
 * @property string $last_active
 * @property integer $online
 *
 * The followings are the available model relations:
 * @property BagOffer[] $bagOffers
 * @property BagOfferVote[] $bagOfferVotes
 * @property ClubCommunityComment[] $clubCommunityComments
 * @property ClubCommunityContent[] $clubCommunityContents
 * @property ClubContest[] $clubContests
 * @property ClubContestUser[] $clubContestUsers
 * @property ClubContestWinner[] $clubContestWinners
 * @property ClubContestWork[] $clubContestWorks
 * @property ClubContestWorkComment[] $clubContestWorkComments
 * @property ClubPhoto[] $clubPhotos
 * @property ClubPhotoComment[] $clubPhotoComments
 * @property ClubPost[] $clubPosts
 * @property Comment[] $comments
 * @property MenstrualUserCycle[] $menstrualUserCycles
 * @property MessageCache[] $messageCaches
 * @property MessageLog[] $messageLogs
 * @property MessageUser[] $messageUsers
 * @property Name[] $names
 * @property RecipeBookRecipe[] $recipeBookRecipes
 * @property RecipeBookRecipeVote[] $recipeBookRecipeVotes
 * @property UserPointsHistory[] $userPointsHistories
 * @property UserSocialService[] $userSocialServices
 * @property UserViaCommunity[] $userViaCommunities
 * @property VaccineDateVote[] $vaccineDateVotes
 */
class User extends CActiveRecord
{

	public $verifyCode;
	public $current_password;
	public $new_password;
	public $new_password_repeat;
	
	public function getAge()
	{
		if ($this->birthday === null) return null;
		
		$date1 = new DateTime($this->birthday);
		$date2 = new DateTime(date('Y-m-d'));
		$interval = $date1->diff($date2);
		return $interval->y;
	}

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
			array('password, current_password, new_password, new_password_repeat', 'length', 'min' => 6, 'max' => 12, 'on' => 'signup'),
            array('online', 'numerical', 'integerOnly'=>true),
            array('email', 'unique', 'on' => 'signup'),
			array('password, current_password, new_password, new_password_repeat', 'length', 'min' => 6, 'max' => 12),
			array('gender', 'boolean'),
			array('phone', 'safe'),
			array('settlement_id, deleted', 'numerical', 'integerOnly' => true),
			array('birthday', 'date', 'format' => 'yyyy-MM-dd'),
		
			//login
			array('email, password', 'required', 'on' => 'login'),
			
			//signup
			array('first_name, email, password, gender', 'required', 'on' => 'signup'),
			array('verifyCode', 'captcha', 'on' => 'signup', 'allowEmpty' => Yii::app()->session->get('service') !== NULL),
            array('email', 'unique', 'on' => 'signup'),
			
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

            'clubCommunityComments' => array(self::HAS_MANY, 'ClubCommunityComment', 'author_id'),
            'clubCommunityContents' => array(self::HAS_MANY, 'ClubCommunityContent', 'author_id'),
            'clubContests' => array(self::HAS_MANY, 'ClubContest', 'contest_user_id'),
            'clubContestUsers' => array(self::HAS_MANY, 'ClubContestUser', 'user_user_id'),
            'clubContestWinners' => array(self::HAS_MANY, 'ClubContestWinner', 'winner_user_id'),
            'clubContestWorks' => array(self::HAS_MANY, 'ClubContestWork', 'work_user_id'),
            'clubContestWorkComments' => array(self::HAS_MANY, 'ClubContestWorkComment', 'comment_user_id'),
            'clubPhotos' => array(self::HAS_MANY, 'ClubPhoto', 'author_id'),
            'clubPhotoComments' => array(self::HAS_MANY, 'ClubPhotoComment', 'author_id'),
            'clubPosts' => array(self::HAS_MANY, 'ClubPost', 'author_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'author_id'),
            'menstrualUserCycles' => array(self::HAS_MANY, 'MenstrualUserCycle', 'user_id'),
            'messageCaches' => array(self::HAS_MANY, 'MessageCache', 'user_id'),
            'messageLogs' => array(self::HAS_MANY, 'MessageLog', 'user_id'),
            'messageUsers' => array(self::HAS_MANY, 'MessageUser', 'user_id'),
            'names' => array(self::MANY_MANY, 'Name', 'name_likes(user_id, name_id)'),
			'recipeBookRecipes' => array(self::HAS_MANY, 'RecipeBookRecipe', 'user_id'),
			'recipeBookRecipeVotes' => array(self::HAS_MANY, 'RecipeBookRecipeVote', 'user_id'),
			'userPointsHistories' => array(self::HAS_MANY, 'UserPointsHistory', 'user_id'),
			'userSocialServices' => array(self::HAS_MANY, 'UserSocialService', 'user_id'),
			'userViaCommunities' => array(self::HAS_MANY, 'UserViaCommunity', 'user_id'),
			'vaccineDateVotes' => array(self::HAS_MANY, 'VaccineDateVote', 'user_id'),
		);
	}

    public function defaultScope()
    {
        return array(
            'condition' => $this->getTableAlias(false, false) . '.deleted = 0',
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
				'class' => 'site.frontend.extensions.ufile.UFileBehavior',
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
				'class' => 'site.frontend.extensions.geturl.EGetUrlBehavior',
				'route' => 'product/view',
				'dataField' => array(
					'id' => 'product_id',
					'title' => 'product_slug',
				),
			),
			'statuses' => array(
				'class' => 'site.frontend.extensions.status.EStatusBehavior',
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
    public static function GetCurrentUserWithBabies(){
        $user = User::model()->with(array('babies'))->findByPk(Yii::app()->user->getId());
        return $user;
    }
}