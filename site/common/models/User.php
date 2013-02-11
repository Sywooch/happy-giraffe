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
 * @property integer $recovery_disable
 * @property integer $remember_code
 * @property int $age
 * @property int $avatar_id
 * @property int $group
 * @property string $updated
 *
 * The followings are the available model relations:
 * @property BagOffer[] $bagOffers
 * @property BagOfferVote[] $bagOfferVotes
 * @property CommunityContent[] $clubCommunityContents
 * @property Contest[] $clubContests
 * @property ContestUser[] $clubContestUsers
 * @property ClubContestWinner[] $clubContestWinners
 * @property ClubContestWork[] $clubContestWorks
 * @property ClubContestWorkComment[] $clubContestWorkComments
 * @property ClubPhoto[] $clubPhotos
 * @property ClubPhotoComment[] $clubPhotoComments
 * @property ClubPost[] $clubPosts
 * @property Comment[] $comments
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
 * @property UserStatus status
 * @property UserMailSub $mail_subs
 * @property address $address
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

    public $day;
    public $month;
    public $year;

    public $baby_day;
    public $baby_month;
    public $baby_year;

    public $fCreated;
    public $baby_birthday;

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
        1 => array('моей жены', 'моей жене', 'Моя жена', 'моя жена', 'вашей жене'),
        2 => '',
        3 => array('моей невесты', 'моей невесте', 'Моя невеста', 'моя невеста', 'вашей невесте'),
        4 => array('моей подруги', 'моей подруге', 'Моя подруга', 'моя подруга', 'вашей подруге'),
    );
    public $men_of = array(
        1 => array('моего мужа', 'моём муже', 'Мой муж', 'мой муж', 'вашем муже'),
        2 => '',
        3 => array('моего жениха', 'моём женихе', 'Мой жених', 'мой жених', 'вашем женихе'),
        4 => array('моего друга', 'моём друге', 'Мой друг', 'мой друг', 'вашем друге'),
    );

    public $partnerTitle = array(
        0 => array(
            1 => 'Муж',
            3 => 'Жених',
            4 => 'Друг',
        ),
        1 => array(
            1 => 'Жена',
            3 => 'Невеста',
            4 => 'Подруга',
        ),
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

    public function getBirthdayString()
    {
        return Yii::app()->dateFormatter->format("d MMMM", $this->birthday);
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
            array('first_name', 'length', 'max' => 50, 'message' => 'Слишком длинное имя'),
            array('last_name', 'length', 'max' => 50, 'message' => 'Слишком длинная фамилия'),
            array('email', 'email', 'message' => 'E-mail не является правильным E-Mail адресом'),
            array('password, current_password, new_password, new_password_repeat', 'length', 'min' => 6, 'max' => 16, 'on' => 'signup, change_password', 'tooShort' => 'минимум 6 символов', 'tooLong' => 'максимум 16 символов'),
            array('online, relationship_status', 'numerical', 'integerOnly' => true),
            array('gender', 'boolean'),
            array('id, phone', 'safe'),
            array('deleted', 'numerical', 'integerOnly' => true),
            array('birthday, baby_birthday', 'date', 'format' => 'yyyy-MM-dd'),
            array('birthday', 'default', 'value' => NULL),
            array('blocked, login_date, register_date', 'safe'),
            array('mood_id', 'exist', 'className' => 'UserMood', 'attributeName' => 'id'),
            array('profile_access, guestbook_access, im_access', 'in', 'range' => array_keys($this->accessLabels)),
            array('avatar_id', 'numerical', 'allowEmpty' => true),
            array('remember_code', 'numerical'),
            array('blog_title', 'safe'),

            //login
            array('email, password', 'required', 'on' => 'login'),
            array('password', 'passwordValidator', 'on' => 'login'),

            //signup
            array('first_name, last_name, password', 'required', 'on' => 'signup,signup_full', 'message' => 'Поле является обязательным'),
            array('email', 'required', 'on' => 'signup,signup_full', 'message' => 'Введите ваш E-mail адрес'),
            array('birthday', 'required', 'on' => 'signup_full', 'message' => 'Поле является обязательным'),
            array('gender', 'required', 'on' => 'signup,signup_full', 'message' => 'укажите свой пол'),
            array('first_name, last_name, gender, birthday, photo', 'safe', 'on' => 'signup,signup_full'),
            array('email', 'unique', 'on' => 'signup,signup_full', 'message' => 'Этот E-Mail уже используется'),

            //change_password
            array('new_password', 'required', 'on' => 'change_password'),
            array('current_password', 'validatePassword', 'on' => 'change_password'),
            array('new_password_repeat', 'compare', 'on' => 'change_password', 'compareAttribute' => 'new_password'),
            array('verifyCode', 'required', 'on' => 'change_password'),
            array('verifyCode', 'captcha', 'on' => 'change_password', 'skipOnError' => true),

            //remember_password
            array('password', 'length', 'min' => 6, 'max' => 15, 'on' => 'remember_password', 'tooShort' => 'минимум 6 символов', 'tooLong' => 'максимум 15 символов'),
        );
    }

    public function validatePassword($attribute, $params)
    {
        if ($this->password !== $this->hashPassword($this->current_password)) $this->addError($attribute, 'Текущий пароль введён неверно.');

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
                $userModel->online = 1;
                $userModel->last_ip = $_SERVER['REMOTE_ADDR'];
                $userModel->save(false);
            } else {
                $this->addError('password', 'Ошибка авторизации');
            }
        } else {
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
            'communities' => array(self::MANY_MANY, 'Community', 'user__users_communities(user_id, community_id)', 'order' => 'position'),

            'clubContests' => array(self::HAS_MANY, 'ClubContest', 'contest_user_id'),
            'clubContestUsers' => array(self::HAS_MANY, 'ClubContestUser', 'user_user_id'),
            'clubContestWinners' => array(self::HAS_MANY, 'ClubContestWinner', 'winner_user_id'),
            'clubContestWorks' => array(self::HAS_MANY, 'ClubContestWork', 'work_user_id'),
            'clubContestWorkComments' => array(self::HAS_MANY, 'ClubContestWorkComment', 'comment_user_id'),
            'comments' => array(self::HAS_MANY, 'Comment', 'author_id'),
            'menstrualUserCycles' => array(self::HAS_MANY, 'MenstrualUserCycle', 'user_id'),
            'UserCaches' => array(self::HAS_MANY, 'UserCache', 'user_id'),
            'Messages' => array(self::HAS_MANY, 'Message', 'user_id'),
            'dialogUsers' => array(self::HAS_MANY, 'DialogUser', 'user_id'),
            'names' => array(self::MANY_MANY, 'Name', 'name_likes(user_id, name_id)'),
            'recipeBookRecipes' => array(self::HAS_MANY, 'RecipeBookRecipe', 'author_id'),
            'userPointsHistories' => array(self::HAS_MANY, 'UserPointsHistory', 'user_id'),
            'userSocialServices' => array(self::HAS_MANY, 'UserSocialService', 'user_id'),

            'commentsCount' => array(self::STAT, 'Comment', 'author_id'),

            'status' => array(self::HAS_ONE, 'UserStatus', 'user_id', 'order' => 'status.created DESC'),
            'purpose' => array(self::HAS_ONE, 'UserPurpose', 'user_id', 'order' => 'purpose.created DESC'),
            'albums' => array(self::HAS_MANY, 'Album', 'author_id', 'scopes' => array('active', 'permission')),
            'interests' => array(self::MANY_MANY, 'Interest', 'interest__users_interests(interest_id, user_id)'),
            'mood' => array(self::BELONGS_TO, 'UserMood', 'mood_id'),
            'partner' => array(self::HAS_ONE, 'UserPartner', 'user_id'),

            'blog_rubrics' => array(self::HAS_MANY, 'CommunityRubric', 'user_id'),
            'blogPostsCount' => array(self::STAT, 'CommunityContent', 'author_id', 'join' => 'JOIN community__rubrics ON t.rubric_id = community__rubrics.id', 'condition' => 'community__rubrics.user_id = t.author_id'),
            'communityPostsCount' => array(self::STAT, 'CommunityContent', 'author_id', 'join' => 'JOIN community__rubrics ON t.rubric_id = community__rubrics.id', 'condition' => 'community__rubrics.user_id IS NULL'),
            'communityContentsCount' => array(self::STAT, 'CommunityContent', 'author_id'),
            'cookRecipesCount' => array(self::STAT, 'CookRecipe', 'author_id'),
            'recipeBookRecipesCount' => array(self::STAT, 'RecipeBookRecipe', 'author_id'),
            //'photosCount' => array(self::STAT, 'AlbumPhoto', 'author_id', 'join' => 'JOIN album__albums a ON t.album_id = a.id', 'condition' => 'a.type IN(0, 1, 3)'),
            'albumsCount' => array(self::STAT, 'Album', 'author_id', 'condition' => 'removed = 0'),

            'communitiesCount' => array(self::STAT, 'Community', 'user__users_communities(user_id, community_id)'),
            'userDialogs' => array(self::HAS_MANY, 'DialogUser', 'user_id'),
            'userDialog' => array(self::HAS_ONE, 'DialogUser', 'user_id'),
            'blogPosts' => array(self::HAS_MANY, 'CommunityContent', 'author_id', 'with' => 'rubric', 'condition' => 'rubric.user_id IS NOT null', 'select' => 'id'),
            'address' => array(self::HAS_ONE, 'UserAddress', 'user_id'),
            'priority' => array(self::HAS_ONE, 'UserPriority', 'user_id'),
            'recipes' => array(self::STAT, 'CookRecipe', 'cook__cook_book(user_id, recipe_id)'),

            'answers' => array(self::HAS_MANY, 'DuelAnswer', 'user_id'),
            'activeQuestion' => array(self::HAS_ONE, 'DuelQuestion', array('question_id' => 'id'), 'through' => 'answers', 'condition' => 'ends > NOW()'),

            'photos' => array(self::HAS_MANY, 'AlbumPhoto', 'author_id'),
            'mail_subs' => array(self::HAS_ONE, 'UserMailSub', 'user_id'),
            'score' => array(self::HAS_ONE, 'UserScores', 'user_id'),
        );
    }

    public function getPhotosCount()
    {
        return AlbumPhoto::model()->count(array(
            'join' => 'JOIN album__albums a ON t.album_id = a.id',
            'condition' => 'a.type IN(0, 1, 3) AND t.author_id = :user_id',
            'params' => array(':user_id' => $this->id),
        ));
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => $this->getTableAlias(false, false) . '.deleted = 0'
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
            'url' => 'Профиль'
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
            if ($this->isNewRecord || $this->scenario == 'change_password' || $this->scenario == 'remember_password') {
                $this->password = $this->hashPassword($this->password);
            }
            return true;
        } else
            return false;
    }

    protected function afterSave()
    {
        parent::afterSave();

        if ($this->trackable->isChanged('mood_id'))
            UserAction::model()->add($this->id, UserAction::USER_ACTION_MOOD_CHANGED, array('model' => $this));

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

            Comment::model()->addGiraffeFirstComment($this->id);

            //create some tables
            Yii::app()->db->createCommand()->insert(UserPriority::model()->tableName(), array('user_id' => $this->id));
            Yii::app()->db->createCommand()->insert(UserScores::model()->tableName(), array('user_id' => $this->id));
            Yii::app()->db->createCommand()->insert(UserAddress::model()->tableName(), array('user_id' => $this->id));
        } else {
            self::clearCache($this->id);

            if (!empty($this->relationship_status))
                UserScores::checkProfileScores($this->id, ScoreAction::ACTION_PROFILE_FAMILY);
        }

        if ($this->trackable->isChanged('online'))
            $this->sendOnlineStatus();

        parent::afterSave();
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
                'class' => 'site.common.behaviors.ESaveRelatedBehavior',
            ),
            'ManyManyLinkBehavior' => array(
                'class' => 'site.common.behaviors.ManyManyLinkBehavior',
            ),
            'trackable' => array(
                'class' => 'site.common.behaviors.TrackableBehavior',
                'attributes' => array('mood_id', 'online'),
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'register_date',
                'updateAttribute' => 'updated',
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
        if (empty($this->avatar_id)) {
            //if ($this->user->gender)
            return false;
        }
        if ($size != 'big')
            return $this->avatar->getAvatarUrl($size);
        else
            return $this->avatar->getPreviewUrl(240, 400, Image::WIDTH);
    }

    public function getAvaOrDefaultImage($size = 'ava')
    {
        if (empty($this->avatar_id)) {
            if ($this->gender == 1)
                return '';
            return false;
        }
        if ($size != 'big')
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
            UserScores::addScores($this->id, ScoreAction::ACTION_FRIEND, 1, User::getUserById($friend_id));
            UserScores::addScores($friend_id, ScoreAction::ACTION_FRIEND, 1, $this);
            UserAction::model()->add($this->id, UserAction::USER_ACTION_FRIENDS_ADDED, array('id' => $friend_id));
            UserAction::model()->add($friend_id, UserAction::USER_ACTION_FRIENDS_ADDED, array('id' => $this->id));
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
            UserScores::removeScores($friend_id, ScoreAction::ACTION_FRIEND, 1, $this);
            UserScores::removeScores($this->id, ScoreAction::ACTION_FRIEND, 1, User::model()->findByPk($friend_id));
            return true;
        }

        return false;
    }

    public function getFriendSelectCriteria()
    {
        return new CDbCriteria(array(
            'join' => 'JOIN ' . Friend::model()->tableName() . ' ON (t.id = friends.user1_id AND friends.user2_id = :user_id) OR (t.id = friends.user2_id AND friends.user1_id = :user_id)',
            'params' => array(':user_id' => $this->id),
        ));
    }

    /**
     * @param string $condition
     * @param array $params
     * @return CActiveDataProvider
     */
    public function getFriends($condition = '', $params = array())
    {
        $criteria = $this->getFriendsCriteria($condition, $params);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getFriendsModels($condition = '', $params = array())
    {
        $criteria = $this->getFriendsCriteria($condition, $params);

        return $this->findAll($criteria);
    }

    public function getFriendsCriteria($condition = '', $params = array())
    {
        $criteria = $this->getFriendSelectCriteria();
        $criteria->mergeWith($this->getCommandBuilder()->createCriteria($condition, $params));

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

    public function getFriendRequestsModels($direction)
    {
        return FriendRequest::model()->findAll($this->getFriendRequestsCriteria($direction));
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
        return $this->relationship_status === null ? '' : $this->relashionshipList[$this->relationship_status];
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

    public function getPartnerTitleOf($id = null, $n = 0)
    {
        if ($id === null)
            $id = $this->relationship_status;

        $list = $this->getPartnerTitlesOf();
        if (isset($list[$id][$n]))
            return $list[$id][$n];
        return '';
    }

    public function getPartnerTitlesOf()
    {
        if ($this->gender == 1)
            return $this->women_of;
        else
            return $this->men_of;
    }

    public function getPartnerTitleNew()
    {
        return $this->partnerTitle[$this->gender][$this->relationship_status];
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

    public function getUrlParams()
    {
        return array(
            'user/profile',
            array(
                'user_id' => $this->id,
            ),
        );
    }

    public function getUrl($absolute = false)
    {
        list($route, $params) = $this->urlParams;
        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method($route, $params);
    }

    public function getBlogUrl()
    {
        return Yii::app()->createUrl('/blog/list', array('user_id' => $this->id));
    }

    public function getPhotosUrl()
    {
        return Yii::app()->createUrl('/albums/user', array('id' => $this->id));
    }

    public function addCommunity($community_id)
    {
        $result = Yii::app()->db->createCommand()
            ->insert('user__users_communities', array('user_id' => $this->id, 'community_id' => $community_id)) != 0;
        if ($result) {
            UserAction::model()->add($this->id, UserAction::USER_ACTION_CLUBS_JOINED, array('community_id' => $community_id));
            FriendEventManager::add(FriendEvent::TYPE_CLUBS_JOINED, array('id' => $community_id, 'user_id' => Yii::app()->user->id));
        }
        return $result;
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

    public function getBlogWidget()
    {
        $criteria = new CDbCriteria(array(
            'select' => array('title', 'created', 'type_id', 'rubric_id', 'author_id'),
            'order' => new CDbExpression('RAND()'),
            'condition' => 'rubric.user_id IS NOT NULL AND t.author_id = :user_id',
            'params' => array(':user_id' => $this->id),
            'limit' => 4,
            'with' => array(
                'rubric',
                'type' => array(
                    'select' => 'slug',
                ),
                'post' => array('select' => array('text', 'content_id', 'photo_id')),
                'video' => array('select' => array('link', 'text', 'content_id', 'photo_id')),
                'commentsCount',
            ),
        ));

        return BlogContent::model()->findAll($criteria);
    }

    public function hasBaby($type = null)
    {
        foreach ($this->babies as $baby)
            if ($baby->type == $type)
                return true;
        return false;
    }

    public function babyCount($total = false)
    {
        $i = 0;
        foreach ($this->babies as $baby)
            if (empty($baby->type) || $total)
                $i++;
        return $i;
    }

    public function getBabyString()
    {
        $array = array();
        if ($this->babyCount() != 0)
            $array[] = $this->babyCount() . ' ' . HDate::GenerateNoun(array('ребёнок', 'ребёнка', 'детей'), $this->babyCount());
        if ($this->hasBaby(Baby::TYPE_PLANNING))
            $array[] = 'Планируем';
        if ($this->hasBaby(Baby::TYPE_WAIT))
            $array[] = 'Ждём';
        return implode(' + ', $array);
    }

    function getRole()
    {
        if ($this->_role === null) {
            $roles = Yii::app()->authManager->getRoles($this->id);
            foreach ($roles as $role) {
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
        if ($this->_authItems === null) {
            $this->_authItems = Yii::app()->authManager->getAuthAssignments($this->id);
        }

        return isset($this->_authItems[$item]);
    }

    public static function findFriends($limit, $offset = 0)
    {
        $criteria = new CDbCriteria(array(
            'select' => 't.*, count(interest__users_interests.user_id) AS interestsCount, count(' . Baby::model()->getTableAlias() . '.id) AS babiesCount',
            'group' => 't.id',
            'having' => 'interestsCount > 0 AND (babiesCount > 0 OR t.relationship_status IS NOT NULL)',
            'condition' => 't.birthday IS NOT NULL AND t.avatar_id IS NOT NULL AND address.country_id IS NOT NULL',
            'join' => 'LEFT JOIN interest__users_interests ON interest__users_interests.user_id = t.id',
            'with' => array(
                'interests' => array(
                    'together' => false,
                ),
                'address' => array(
                    'together' => true,
                ),
                'address.country',
                'address.region',
                'address.city',
                'address.city.district',
                'babies' => array(
                    'together' => true,
                    //'condition' => 'sex != 0 OR type IS NOT NULL',
                ),
                'status'
            ),
            'order' => 'register_date DESC',
            'limit' => $limit,
            'offset' => $offset,
        ));

        if (!Yii::app()->user->isGuest) {
            $criteria->addCondition('
                t.id != :me AND t.id NOT IN (
                SELECT user1_id FROM friends WHERE user2_id = :me
                UNION
                SELECT user2_id FROM friends WHERE user1_id = :me
            )');
            $criteria->params = array(':me' => Yii::app()->user->id);
        }

        return User::model()->findAll($criteria);
    }

    public function getCanDuel()
    {
        $connection = Yii::app()->db;
        $sql = '
            SELECT count(*)
            FROM ' . DuelQuestion::model()->tableName() . ' q
            JOIN ' . DuelAnswer::model()->tableName() . ' a ON q.id = a.question_id
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

    public function getBlogPopular()
    {
        return BlogContent::model()->full()->findAll(array(
            'condition' => 'rubric.user_id = :user_id',
            'params' => array(':user_id' => $this->id),
            'order' => 't.rate DESC',
            'limit' => 3,
        ));
    }

    function createPassword($length)
    {
        $chars = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $i = 0;
        $password = "";
        while ($i <= $length) {
            $password .= $chars{mt_rand(0, strlen($chars) - 1)};
            $i++;
        }
        return $password;
    }

    function getConfirmationCode()
    {
        return md5($this->email . md5($this->password));
    }

    public function UpdateUser($id)
    {
        Yii::app()->db->createCommand()->update($this->tableName(), array('updated' => date("Y-m-d H:i:s")), 'id=' . $id);
    }

    public function sendOnlineStatus()
    {
        $additionalCriteria = new CDbCriteria(array(
            'select' => 't.id',
            'index' => 'id',
        ));

        $contacts = Im::getContacts($this->id, Im::IM_CONTACTS_ALL, $additionalCriteria);
        $friends = $this->getFriendsModels($additionalCriteria);

        $users = $contacts + $friends;

        $comet = new CometModel;
        $comet->type = CometModel::TYPE_ONLINE_STATUS_CHANGE;
        foreach ($users as $k => $u) {
            $comet->send($u->id, array(
                'online' => $this->online,
                'user_id' => $this->id,
                'is_friend' => isset($friends[$k]),
            ));
        }
    }

    public static function getWorkersIds()
    {
        return Yii::app()->db
            ->createCommand()
            ->select('id')
            ->from('users')
            ->where('`group` > 0')
            ->queryColumn();
    }

    public function getSystemAlbum($type)
    {
//        $album = Album::model()->cache(3600*24)->find('type = :type AND author_id = :user_id', array(':type' => $type, ':user_id' => $this->id));
//        if ($album === null)
//            return Album::model()->find('type = :type AND author_id = :user_id', array(':type' => $type, ':user_id' => $this->id));

        $album = Album::model()->find('type = :type AND author_id = :user_id', array(':type' => $type, ':user_id' => $this->id));
        return $album;
    }

    /**
     * @return UserMailSub
     */
    public function getMailSubs()
    {
        if ($this->mail_subs === null) {
            $mail_sub = new UserMailSub();
            $mail_sub->user_id = $this->id;
            $mail_sub->save();
            return $mail_sub;
        }

        return $this->mail_subs;
    }

    public function getContestWork($contest_id)
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('title', 'rate', 'contest_id');
        $criteria->compare('user_id', $this->id);
        $criteria->compare('contest_id', $contest_id);
        $criteria->with = array(
            'photoAttach' => array(
                'select' => array('id'),
                'with' => array(
                    'photo' => array('select' => array('id', 'author_id', 'fs_name')),
                )
            ),
        );
        $criteria->together = true;

        return ContestWork::model()->find($criteria);
    }

    public function hasFeature($feature_id)
    {
        return false;
    }

    public function getPregnantBaby()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'birthday > "'.date("Y-m-d") .'"';
        $criteria->compare('parent_id', $this->id);
        $criteria->compare('type', Baby::TYPE_WAIT);

        return Baby::model()->find($criteria);
    }

    public function getEvent()
    {
        $row = array(
            'id' => $this->id,
            'last_updated' => time(),
            'type' => Event::EVENT_USER,
        );

        $event = Event::factory(Event::EVENT_USER);
        $event->attributes = $row;
        return $event;
    }

    public function sendEvent()
    {
        $event = $this->event;
        $params = array(
            'blockId' => $event->blockId,
            'code' => $event->code,
        );

        $comet = new CometModel;
        $comet->send('whatsNewIndex', $params, CometModel::WHATS_NEW_UPDATE);
    }
}