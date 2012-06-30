<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property int $deleted
 * @property integer $gender
 * @property string $birthday
 * @property string $last_active
 * @property integer $online
 * @property string $register_date
 * @property string $login_date
 * @property string $last_ip
 * @property string $relationship_status
 * @property UserAddress $userAddress
 * @property integer $recovery_disable
 * @property integer $remember_code
 * @property int $age
 *
 * The followings are the available model relations:
 * @property BagOffer[] $bagOffers
 * @property BagOfferVote[] $bagOfferVotes
 * @property CommunityComment[] $clubCommunityComments
 * @property CommunityContent[] $clubCommunityContents
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
 * @property UserCache[] $UserCaches
 * @property Message[] $Messages
 * @property DialogUser[] $DialogUsers
 * @property Name[] $names
 * @property RecipeBookRecipe[] $recipeBookRecipes
 * @property RecipeBookRecipeVote[] $recipeBookRecipeVotes
 * @property UserPointsHistory[] $userPointsHistories
 * @property UserSocialService[] $userSocialServices
 * @property UserViaCommunity[] $userViaCommunities
 * @property VaccineDateVote[] $vaccineDateVotes
 * @property Album[] $albums
 * @property Interest[] interests
 * @property UserPartner partner
 * @property Baby[] babies
 * @property AlbumPhoto $avatar
 *
 * @method User active()
 */
class User extends HActiveRecord
{
    const HAPPY_GIRAFFE = 1;
    public $verifyCode;
    public $current_password;
    public $new_password;
    public $new_password_repeat;
    public $remember;
    public $photo;
    public $assigns;
    private $_role = null;
    private $_authItems = null;

    public $authorsRate;
    public $commentatorsRate;
    public $interestsCount;
    public $babiesCount;

    public $women_rel = array(
        1 => 'Замужем',
        2 => 'Не замужем',
        3 => 'Невеста',
        4 => 'Есть друг',
    );
    public $men_rel = array(
        1 => 'Женат',
        2 => 'Не женат',
        3 => 'Жених',
        4 => 'Есть подруга',
    );
    public $women_of = array(
        1 => 'жены',
        2 => '',
        3 => 'невесты',
        4 => 'подруги',
    );
    public $men_of = array(
        1 => 'мужа',
        2 => '',
        3 => 'жениха',
        4 => 'друга',
    );

    public $accessLabels = array(
        'all' => 'гости',
        'registered' => 'зарегистрированные пользователи',
        'friends' => 'только друзья',
    );

    public function getAccessLabel()
    {
        return $this->accessLabels[$this->access];
    }

    public function getAge()
    {
        if ($this->birthday === null) return null;

        $birthday = new DateTime($this->birthday);
        $now = new DateTime(date('Y-m-d'));
        $interval = $birthday->diff($now);
        $age = $interval->y;
        return $age;
    }

    public function getAgeSuffix()
    {
        return HDate::ageSuffix($this->age);
    }

    public function getNormalizedAge()
    {
        return $this->age . ' ' . $this->ageSuffix;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
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
            array('online, relationship_status', 'numerical', 'integerOnly' => true),
            array('email', 'unique', 'on' => 'signup'),
            array('gender', 'boolean'),
            array('id, phone', 'safe'),
            array('deleted', 'numerical', 'integerOnly' => true),
            array('birthday', 'date', 'format' => 'yyyy-MM-dd'),
            array('birthday', 'default', 'value' => NULL),
            array('blocked, login_date, register_date', 'safe'),
            array('mood_id', 'exist', 'className' => 'UserMood', 'attributeName' => 'id'),
            array('profile_access, guestbook_access, im_access', 'in', 'range' => array_keys($this->accessLabels)),
            array('avatar_id', 'numerical', 'allowEmpty' => true),
            array('remember_code', 'numerical'),

            //login
            array('email, password', 'required', 'on' => 'login'),
            array('password', 'passwordValidator', 'on' => 'login'),

            //signup
            array('first_name, email, password, gender', 'required', 'on' => 'signup'),
            array('verifyCode', 'captcha', 'on' => 'signup', 'allowEmpty' => Yii::app()->session->get('service') !== NULL),
            array('email', 'unique', 'on' => 'signup'),
            array('first_name, last_name, birthday, photo', 'safe', 'on' => 'signup'),

            //change_password
            array('new_password', 'required', 'on' => 'change_password'),
            array('current_password', 'validatePassword', 'on' => 'change_password'),
            array('new_password_repeat', 'compare', 'on' => 'change_password', 'compareAttribute' => 'new_password'),
            array('verifyCode', 'captcha', 'on' => 'change_password', 'allowEmpty' => false),

            //remember_password
            array('password', 'length', 'min' => 6, 'max' => 12, 'on' => 'remember_password'),
        );
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->password !== $this->hashPassword($this->current_password)) $this->addError('password', 'Текущий пароль введён неверно.');

    }

    public function passwordValidator($attribute, $params)
    {
        if ($this->password == '' || $this->email == '')
            return false;
        $userModel = $this->find(array(
            'condition' => 'email=:email AND password=:password and blocked = 0 and deleted = 0',
            'params' => array(
                ':email' => $_POST['User']['email'],
                ':password' => $this->hashPassword($_POST['User']['password']),
            )));
        if ($userModel) {
            $identity = new UserIdentity($userModel->getAttributes());
            $identity->authenticate();
            if ($identity->errorCode == UserIdentity::ERROR_NONE) {
                $duration = $this->remember == 1 ? 2592000 : 0;
                Yii::app()->user->login($identity, $duration);
                $userModel->login_date = date('Y-m-d H:i:s');
                $userModel->last_ip = $_SERVER['REMOTE_ADDR'];
                $userModel->save(false);
            }
            else {
                $this->addError('password', 'Ошибка авторизации');
            }
        }
        else {
            $this->addError('password', 'Ошибка авторизации');
        }
    }

    public function checkUserPassword($attribute, $params)
    {
        $userModel = $this->find(array('condition' => 'email="' . $this->email . '" AND password="' . $this->hashPassword($this->password) . '"'));
        if (!$userModel) {
            $this->addError($attribute, 'Не найден пользователь с таким именем и паролем');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'avatar' => array(self::BELONGS_TO, 'AlbumPhoto', 'avatar_id'),
            'babies' => array(self::HAS_MANY, 'Baby', 'parent_id'),
            'realBabies' => array(self::HAS_MANY, 'Baby', 'parent_id', 'condition' => ' type IS NULL '),
            'social_services' => array(self::HAS_MANY, 'UserSocialService', 'user_id'),
            'communities' => array(self::MANY_MANY, 'Community', 'user__users_communities(user_id, community_id)'),

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
            'UserCaches' => array(self::HAS_MANY, 'UserCache', 'user_id'),
            'Messages' => array(self::HAS_MANY, 'Message', 'user_id'),
            'dialogUsers' => array(self::HAS_MANY, 'DialogUser', 'user_id'),
            'names' => array(self::MANY_MANY, 'Name', 'name_likes(user_id, name_id)'),
            'recipeBookRecipes' => array(self::HAS_MANY, 'RecipeBookRecipe', 'user_id'),
            'recipeBookRecipeVotes' => array(self::HAS_MANY, 'RecipeBookRecipeVote', 'user_id'),
            'userPointsHistories' => array(self::HAS_MANY, 'UserPointsHistory', 'user_id'),
            'userSocialServices' => array(self::HAS_MANY, 'UserSocialService', 'user_id'),
            'userViaCommunities' => array(self::HAS_MANY, 'UserViaCommunity', 'user_id'),
            'vaccineDateVotes' => array(self::HAS_MANY, 'VaccineDateVote', 'user_id'),

            'commentsCount' => array(self::STAT, 'Comment', 'author_id'),

            'status' => array(self::HAS_ONE, 'UserStatus', 'user_id', 'order' => 'status.created DESC'),
            'purpose' => array(self::HAS_ONE, 'UserPurpose', 'user_id', 'order' => 'purpose.created DESC'),
            'albums' => array(self::HAS_MANY, 'Album', 'author_id', 'scopes' => array('active', 'permission')),
            'interests' => array(self::MANY_MANY, 'Interest', 'interest__users_interests(interest_id, user_id)'),
            'mood' => array(self::BELONGS_TO, 'UserMood', 'mood_id'),
            'partner' => array(self::HAS_ONE, 'UserPartner', 'user_id'),

            'blog_rubrics' => array(self::HAS_MANY, 'CommunityRubric', 'user_id'),
            'blogPostsCount' => array(self::STAT, 'CommunityContent', 'author_id', 'join' => 'JOIN community__rubrics ON t.rubric_id = community__rubrics.id', 'condition' => 'community__rubrics.user_id = t.author_id'),

            'communitiesCount' => array(self::STAT, 'Community', 'user__users_communities(user_id, community_id)'),
            'userDialogs' => array(self::HAS_MANY, 'DialogUser', 'user_id'),
            'blogPosts' => array(self::HAS_MANY, 'CommunityContent', 'author_id', 'with' => 'rubric', 'condition' => 'rubric.user_id IS NOT null', 'select' => 'id'),
            'userAddress' => array(self::HAS_ONE, 'UserAddress', 'user_id'),

            'answers' => array(self::HAS_MANY, 'DuelAnswer', 'user_id'),
            'activeQuestion' => array(self::HAS_ONE, 'DuelQuestion', array('question_id' => 'id'), 'through' => 'answers', 'condition' => 'ends > NOW()'),
        );
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => $this->getTableAlias(false, false) . '.deleted = 0 and ' . $this->getTableAlias(false, false) . '.blocked = 0'
            ),
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
            'remember' => 'Запомнить меня',
            'role' => 'Роль',
            'fullName' => 'Имя пользователя',
            'last_name' => 'Фамилия',
            'assigns' => 'Права',
            'last_active' => 'Последняя активность',
            'url'=>'Профиль'
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->register_date = date("Y-m-d H:i:s");
            }
            if ($this->isNewRecord || $this->scenario == 'change_password' || $this->scenario == 'remember_password') {
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

        foreach ($this->social_services as $service) {
            $service->user_id = $this->id;
            $service->save();
        }

        /*Yii::app()->mc->saveUser($this);*/

        if ($this->isNewRecord) {
            //силнал о новом юзере
            $signal = new UserSignal();
            $signal->user_id = (int)$this->id;
            $signal->signal_type = UserSignal::TYPE_NEW_USER_REGISTER;
            $signal->item_name = 'User';
            $signal->item_id = (int)$this->id;
            $signal->save();

            //рубрика для блога
            $rubric = new CommunityRubric;
            $rubric->title = 'Обо всём';
            $rubric->user_id = $this->id;
            $rubric->save();

            //коммент от веселого жирафа
            $comment = new Comment('giraffe');
            $comment->author_id = User::HAPPY_GIRAFFE;
            $comment->entity = get_class($this);
            $comment->entity_id = $this->id;
            $comment->save();
        } else {
            self::clearCache($this->id);

            if (!empty($this->relationship_status))
                UserScores::checkProfileScores($this->id, ScoreActions::ACTION_PROFILE_FAMILY);
        }

        return true;
    }

    public function beforeDelete()
    {
        UserSignal::closeRemoved($this);
        return false;
    }

    public function hashPassword($password)
    {
        return md5($password);
    }

    public function behaviors()
    {
        return array(
//			'attribute_set' => array(
//				'class'=>'attribute.AttributeSetBehavior',
//				'table'=>'shop__product_attribute_set',
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
            'ManyManyLinkBehavior' => array(
                'class' => 'site.common.behaviors.ManyManyLinkBehavior',
            ),
        );
    }

    /**
     * @static
     * @return User
     */
    public static function GetCurrentUserWithBabies()
    {
        $user = User::model()->with(array('babies'))->findByPk(Yii::app()->user->id);
        return $user;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @static
     * @param $id
     * @return User
     */
    public static function getUserById($id)
    {
        $user = User::model()->findByPk($id);
        return $user;
    }

    public static function clearCache($id)
    {
        $cacheKey = 'yii:dbquery' . Yii::app()->db->connectionString . ':' . Yii::app()->db->username;
        $cacheKey .= ':' . 'SELECT * FROM `users` `t` WHERE `t`.`id`=\'' . $id . '\' LIMIT 1:a:0:{}';
        if (isset(Yii::app()->cache))
            Yii::app()->cache->delete($cacheKey);
    }

    public function getAva($size = 'ava')
    {
        if(empty($this->avatar_id))
            return false;
        if($size != 'big')
            return $this->avatar->getAvatarUrl($size);
        else
            return $this->avatar->getPreviewUrl(240, 400, Image::WIDTH);
    }

    public function getPartnerPhotoUrl()
    {
        $url = '';
        return $url;
    }

    public function getDialogUrl()
    {
        if (Yii::app()->user->isGuest || $this->id == Yii::app()->user->id)
            return '#';

        return Yii::app()->createUrl('/im/default/create', array('id' => $this->id));
    }

    public function getAssigns()
    {
        $assigns = Yii::app()->authManager->getAuthItems(0, $this->id);
        if (empty($assigns))
            return 'user';
        $res = '';
        foreach ($assigns as $assign) {
            $res .= $assign->description . '<br>';
        }
        return trim($res, '<br>');
    }

    /**
     * Возвращает приоритет пользователя для окучивания модераторами
     * @return int
     */
    public function getUserPriority()
    {
        //если много пишет, то наивысший приоритет 6
        if (Comment::getUserAvarageCommentsCount($this) > 10)
            return 1;

        //с каждой неделей пребывания на сервере приоритет уменьшается
        $weeks_gone = floor((time() - strtotime($this->register_date)) / 604800);
        if ($weeks_gone < 5)
            return $weeks_gone + 2;
        else
            return 1;
    }

    public function isNewComer()
    {
        //с каждой неделей пребывания на сервере приоритет уменьшается
        if (!isset($this->register_date))
            return false;
        $weeks_gone = floor((time() - strtotime($this->register_date)) / 604800);

        if ($this->getRole() == 'user' && $weeks_gone < 5)
            return true;
        return false;
    }

    /**
     * @param $friend_id
     * @return CDbCriteria
     */
    public function getFriendCriteria($friend_id)
    {
        return new CDbCriteria(array(
            'condition' => '(user1_id = :user_id AND user2_id = :friend_id) OR (user1_id = :friend_id AND user2_id = :user_id)',
            'params' => array(':user_id' => $this->id, ':friend_id' => $friend_id),
        ));
    }

    /**
     * @param $friend_id
     * @return bool
     */
    public function addFriend($friend_id)
    {
        if ($this->isFriend($friend_id)) return false;
        $friend = new Friend;
        $friend->user1_id = $this->id;
        $friend->user2_id = $friend_id;
        if ($friend->save()) {
            UserScores::addScores($this->id, ScoreActions::ACTION_FRIEND, 1, User::getUserById($friend_id));
            UserScores::addScores($friend_id, ScoreActions::ACTION_FRIEND, 1, $this);
            return true;
        }
        return false;
    }

    /**
     * @param $friend_id
     * @return bool
     */
    public function isFriend($friend_id)
    {
        return Friend::model()->count($this->getFriendCriteria($friend_id)) != 0;
    }

    public function isInvitedBy($user_id)
    {
        return FriendRequest::model()->findByAttributes(array(
            'from_id' => $user_id,
            'to_id' => $this->id,
            'status' => 'pending',
        )) !== null;
    }

    /**
     * @param $friend_id
     * @return bool
     */
    public function delFriend($friend_id)
    {
        $res = Friend::model()->deleteAll($this->getFriendCriteria($friend_id));
        if ($res != 0) {
            UserScores::removeScores($friend_id, ScoreActions::ACTION_FRIEND, 1, $this);
            UserScores::removeScores($this->id, ScoreActions::ACTION_FRIEND, 1, User::model()->findByPk($friend_id));
            return true;
        }

        return false;
    }

    public function getFriendSelectCriteria()
    {
        return new CDbCriteria(array(
            'join' => 'JOIN ' . Friend::model()->tableName() . ' ON (t.id = friends.user1_id AND friends.user2_id = :user_id) OR (t.id = friends.user2_id AND friends.user1_id = :user_id)',
            'scopes'=>array('active'),
            'params' => array(':user_id' => $this->id),
        ));
    }

    /**
     * @param string $condition
     * @param array $params
     * @return array
     */
    public function getFriends($condition = '', $params = array())
    {
        $criteria = $this->getFriendSelectCriteria();
        $criteria->mergeWith($this->getCommandBuilder()->createCriteria($condition, $params));

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getFriendsCriteria($additional_criteria)
    {
        $criteria = $this->getFriendSelectCriteria();
        $criteria->mergeWith($additional_criteria);

        return $criteria;
    }

    /**
     * @return int
     */
    public function getFriendsCount($onlineOnly = false)
    {
        $criteria = $this->getFriendSelectCriteria();
        if ($onlineOnly) $criteria->compare('online', true);
        return self::model()->count($criteria);
    }

    public function getFriendRequestsCriteria($direction)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('status', 'pending');

        if ($direction == 'incoming') {
            $criteria->compare('to_id', $this->id);
            $criteria->with = 'from';
        } else {
            $criteria->compare('from_id', $this->id);
            $criteria->with = 'to';
        }

        return $criteria;
    }

    /**
     * @return CActiveDataProvider
     */
    public function getFriendRequests($direction)
    {
        return new CActiveDataProvider('FriendRequest', array(
            'criteria' => $this->getFriendRequestsCriteria($direction),
        ));
    }

    public function getFriendRequestsCount($direction)
    {
        return FriendRequest::model()->count($this->getFriendRequestsCriteria($direction));
    }

    public function getRelashionshipList()
    {
        if ($this->gender == 0)
            return $this->women_rel;
        if ($this->gender == 1)
            return $this->men_rel;
        return array();
    }

    public function getRelationshipStatusString()
    {
        return $this->relationship_status === null ? '' : mb_strtolower($this->relashionshipList[$this->relationship_status], 'utf-8');
    }

    public function getPartnerTitle($id)
    {
        if ($this->gender == 1) {
            if ($id == 1)
                return 'Моя жена';
            if ($id == 3)
                return 'Моя невеста';
            if ($id == 4)
                return 'Моя подруга';
        } else {
            if ($id == 1)
                return 'Мой муж';
            if ($id == 3)
                return 'Мой жених';
            if ($id == 4)
                return 'Мой друг';
        }

        return '';
    }

    public function getPartnerTitleOf($id = null)
    {
        if ($id === null)
            $id = $this->relationship_status;

        $list = $this->getPartnerTitlesOf();
        if (isset($list[$id]))
            return $list[$id];
        return '';
    }

    public function getPartnerTitlesOf()
    {
        if ($this->gender == 1)
            return $this->women_of;
        else
            return $this->men_of;
    }

    public static function relationshipStatusHasPartner($status_id)
    {
        if (in_array($status_id, array(1, 3, 4)))
            return true;
        return false;
    }

    public function hasPartner()
    {
        if (in_array($this->relationship_status, array(1, 3, 4)))
            return true;
        return false;
    }

    public function calculateAccess($attribute, $user_id)
    {
        switch ($this->$attribute) {
            case 'all':
                return true;
                break;
            case 'registered':
                return $user_id !== null;
                break;
            case 'friends':
                return $this->isFriend($user_id) || $user_id == $this->id;
                break;
        }
    }

    public function getUrl($absolute = false)
    {
        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method('user/profile', array('user_id' => $this->id));
    }

    public function addCommunity($community_id)
    {
        return Yii::app()->db->createCommand()
            ->insert('user__users_communities', array('user_id' => $this->id, 'community_id' => $community_id)) != 0;
    }

    public function delCommunity($community_id)
    {
        return Yii::app()->db->createCommand()
            ->delete('user__users_communities', 'user_id = :user_id AND community_id = :community_id', array(':user_id' => $this->id, ':community_id' => $community_id)) != 0;
    }

    public function isInCommunity($community_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('user__users_communities')
            ->where('user_id = :user_id AND community_id = :community_id', array(':user_id' => $this->id, ':community_id' => $community_id))
            ->queryScalar() != 0;
    }

    public function getScores()
    {
        $criteria = new CDbCriteria;
        $criteria->with =array('level' => array('select' => array('title')));
        $criteria->compare('user_id', $this->id);
        $criteria->select = array('scores', 'level_id');
        $model = UserScores::model()->find($criteria);
        if ($model === null) {
            $model = new UserScores;
            $model->user_id = $this->id;
            $model->save();
        }

        return $model;
    }

    public function getUserAddress()
    {
        if ($this->userAddress === null) {
            $address = new UserAddress();
            $address->user_id = $this->id;
            $address->save();
            $this->userAddress = $address;
        }
        return $this->userAddress;
    }

    public function getBlogWidget()
    {
        $criteria = new CDbCriteria(array(
            'order' => new CDbExpression('RAND()'),
            'condition' => 'rubric.user_id IS NOT NULL AND t.author_id = :user_id',
            'params' => array(':user_id' => $this->id),
            'limit' => 4,
        ));

        return BlogContent::model()->full()->findAll($criteria);
    }

    public function hasBaby($type = null)
    {
        foreach($this->babies as $baby)
            if ($baby->type == $type)
                return true;
        return false;
    }

    public function babyCount()
    {
        $i = 0;
        foreach($this->babies as $baby)
            if (empty($baby->type))
                $i++;
        return $i;
    }

    function getRole()
    {
        if ($this->_role === null) {
            $roles = Yii::app()->authManager->getRoles($this->id);
            foreach($roles as $role){
                $this->_role = $role->name;
                return $role->name;
            }

            $this->_role = 'user';
        }
        return $this->_role;
    }

    function isUser()
    {
        return $this->role == 'user';
    }

    public function checkAuthItem($item)
    {
        if ($this->_authItems === null){
            $this->_authItems = Yii::app()->authManager->getAuthAssignments($this->id);
        }

        return isset($this->_authItems[$item]);
    }

    public static function findFriends($limit, $offset = 0)
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.*, count(interest__users_interests.user_id) AS interestsCount, count(' . Baby::model()->getTableAlias() .  '.id) AS babiesCount',
            'group' => 't.id',
            'having' => 'interestsCount > 0 AND (babiesCount > 0 OR t.relationship_status IS NOT NULL)',
            'condition' => 't.avatar_id IS NOT NULL AND userAddress.country_id IS NOT NULL',
            'join' => 'LEFT JOIN interest__users_interests ON interest__users_interests.user_id = t.id',
            'with' => array(
                'interests' => array(
                    'together' => false,
                ),
                'userAddress',
                'babies' => array(
                    'together' => true,
                    'condition' => 'sex != 0 OR type IS NOT NULL',
                ),
            ),
            'order' => 'register_date DESC',
            'limit' => $limit,
            'offset' => $offset,
        ));

        if (! Yii::app()->user->isGuest) {
            $criteria->join .= ' LEFT JOIN friends ON (friends.user1_id = :me AND friends.user2_id = t.id) OR (friends.user2_id = :me AND friends.user1_id = t.id)';
            $criteria->addCondition('t.id != :me AND friends.id IS NULL');
            $criteria->params = array(':me' => Yii::app()->user->id);
        }

        return User::model()->findAll($criteria);
    }

    public function getCanDuel()
    {
        $connection = Yii::app()->db;
        $sql = '
            SELECT count(*)
            FROM ' . DuelQuestion::model()->tableName() .' q
            JOIN ' . DuelAnswer::model()->tableName() .' a ON q.id = a.question_id
            WHERE (ends > NOW() OR ends IS NULL) AND user_id = :user_id;
        ';
        $command = $connection->createCommand($sql);
        $command->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        return $command->queryScalar() == 0;
    }

    public function getActivityUpdated()
    {
        if (UserAttributes::get($this->id, 'activityLastVisited') === false) {
            return true;
        } elseif (($activityLastUpdated = Yii::app()->cache->get('activityLastUpdated')) === false) {
            return false;
        } else {
            return $activityLastUpdated > UserAttributes::get($this->id, 'activityLastVisited');
        }
    }
}