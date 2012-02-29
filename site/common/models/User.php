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
 * @property string $country_id
 * @property int $deleted
 * @property integer $gender
 * @property string $birthday
 * @property string $settlement_id
 * @property string $mail_id
 * @property string $last_active
 * @property integer $online
 * @propery string $register_date
 * @propery string $login_date
 * @propery integer $street_id
 * @propery string $room
 * @propery string $house
 * @propery string $last_ip
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
 * @property GeoCountry $country
 * @property GeoRusSettlement $settlement
 * @property GeoRusStreet $street
 * @property Album[] $albums
 */
class User extends CActiveRecord
{
    public $verifyCode;
    public $current_password;
    public $new_password;
    public $new_password_repeat;
    public $remember;

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
    public static function model($className = __CLASS__)
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
            array('online', 'numerical', 'integerOnly' => true),
            array('email', 'unique', 'on' => 'signup'),
            array('password, current_password, new_password, new_password_repeat', 'length', 'min' => 6, 'max' => 12),
            array('gender', 'boolean'),
            array('phone', 'safe'),
            array('settlement_id, deleted', 'numerical', 'integerOnly' => true),
            array('birthday', 'date', 'format' => 'yyyy-MM-dd'),
            array('blocked, login_date, register_date', 'safe'),

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
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'babies' => array(self::HAS_MANY, 'Baby', 'parent_id'),
            'social_services' => array(self::HAS_MANY, 'UserSocialService', 'user_id'),
            'settlement' => array(self::BELONGS_TO, 'GeoRusSettlement', 'settlement_id'),
            'country' => array(self::BELONGS_TO, 'GeoCountry', 'country_id'),
            'street' => array(self::BELONGS_TO, 'GeoRusStreet', 'street_id'),
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

            'commentsCount' => array(self::STAT, 'Comment', 'author_id'),

            'status' => array(self::HAS_ONE, 'UserStatus', 'user_id', 'order' => 'status.created DESC'),
            'purpose' => array(self::HAS_ONE, 'UserPurpose', 'user_id', 'order' => 'purpose.created DESC'),
            'albums' => array(self::HAS_MANY, 'Album', 'user_id'),
        );
    }

    public function scopes()
    {
        return array(
            'active' => $this->getTableAlias(false, false) . '.deleted = 0'
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
            'role'=>'Роль',
            'fullName' => 'Имя пользователя',
            'last_name'=>'Фамилия',
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
        $criteria->compare('external_id', $this->external_id);
        $criteria->compare('nick', $this->nick, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('pic_small', $this->pic_small, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
        ));
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord OR $this->scenario == 'change_password') {
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
        if (!$this->isNewRecord) {
            $this->register_date = date("Y-m-d H:i:s");
            //            User::model()->cache(0)->findByPk($this->id);
            //            Yii::app()->cache->delete('User_' . $this->id);
            self::clearCache($this->id);
        }
    }

    public function hashPassword($password)
    {
        return md5($password);
    }

    public function behaviors()
    {
        return array(
            'behavior_ufiles' => array(
                'class' => 'site.frontend.extensions.ufile.UFileBehavior',
                'fileAttributes' => array(
                    'pic_small' => array(
                        'fileName' => 'upload/avatars/*/<date>-{id}-<name>.<ext>',
                        'fileItems' => array(
                            'ava' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                                'accurate_resize' => array(
                                    'width' => 76,
                                    'height' => 79,
                                ),
                            ),
                            'mini' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                                'accurate_resize' => array(
                                    'width' => 38,
                                    'height' => 37,
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
    public static function GetCurrentUserWithBabies()
    {
        $user = User::model()->with(array('babies'))->findByPk(Yii::app()->user->getId());
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
        $user = User::model()->cache(3600 * 24)->findByPk($id);
        return $user;

        //        $value = Yii::app()->cache->get('User_' . $id);
        //        if ($value === false) {
        //            $value = User::model()->findByPk($id);
        //            if ($value === null)
        //                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        //
        //            Yii::app()->cache->set('User_' . $id, $value, 5184000);
        //        }
        //        return $value;
    }

    public static function clearCache($id)
    {
        //        $dep = new CDbCacheDependency('SELECT NOW()');
        //        return User::model()->cache(3600*24, $dep)->findByPk($id);
        $cacheKey = 'yii:dbquery' . Yii::app()->db->connectionString . ':' . Yii::app()->db->username;
        $cacheKey .= ':' . 'SELECT * FROM `user` `t` WHERE `t`.`id`=\'' . $id . '\' LIMIT 1:a:0:{}';
        if (isset(Yii::app()->cache))
            Yii::app()->cache->delete($cacheKey);
    }

    public function getMiniAva()
    {
        $url = $this->pic_small->getUrl('mini');
        if (empty($url)) {
            if ($this->gender == 1)
                return '/images/mini_noimg_male.png';
            elseif ($this->gender == 0)
                return '/images/mini_noimg_female.png';
            else
                return '/images/mini_noimg.png';
        }
        else
            return $url;
    }

    public function getAva()
    {
        $url = $this->pic_small->getUrl('ava');
        if (empty($url)) {
            if ($this->gender == 1)
                return '/images/ava_noimg_male.png';
            elseif ($this->gender == 0)
                return '/images/ava_noimg_female.png';
            else
                return '/images/ava_noimg.png';
        }
        else
            return $url;
    }

    public function getDialogLink()
    {
        if (Yii::app()->user->isGuest)
            return '';

        Yii::import('site.frontend.modules.im.models.*');
        Yii::import('site.frontend.modules.im.components.*');

        $dialog_id = Im::model()->getDialogIdByUser($this->id);
        if (isset($dialog_id)) {
            $url = Yii::app()->createUrl('/im/default/dialog', array('id' => $dialog_id));
        } else {
            $url = Yii::app()->createUrl('/im/default/create', array('id' => $this->id));
        }

        return CHtml::link('написать', $url);
    }

    public function getFlag()
    {
        Yii::import('site.frontend.modules.geo.models.*');

        if (!empty($this->country_id))
            return '<img src="/images/blank.gif" class="flag flag-' . strtolower($this->country->iso_code) . '" title="' . $this->country->name . '" />';
        else
            return '';
    }

    public function getLocationString()
    {
        Yii::import('site.frontend.modules.geo.models.*');

        if (empty($this->country_id))
            return '';

        $str = $this->country->name;
        if (!empty($this->settlement_id)) {
            if (empty($this->settlement->region_id)) {
                $str .= ', ' . $this->settlement->name;
            } elseif (empty($this->settlement->district_id)) {
                $type = empty($this->settlement->type_id) ? '' : $this->settlement->type->name;
                $str .= ', ' . $this->settlement->region->name . ', ' . $type . ' ' . $this->settlement->name;
            } else {
                $type = empty($this->settlement->type_id) ? '' : $this->settlement->type->name;
                $str .= ', ' . $this->settlement->region->name . ', ' . $this->settlement->district->name . ', ' . $type . ' ' . $this->settlement->name;
            }

            if (!empty($this->street_id))
                $str .= ', ' . $this->street->name;
            if (!empty($this->house))
                $str .= ', д. ' . $this->house;

            return $str;
        }
        return $str;
    }

    public function getPublicLocation()
    {
        Yii::import('site.frontend.modules.geo.models.*');

        if (empty($this->country_id))
            return '';

        $str = $this->country->name;
        if (!empty($this->settlement_id)) {
            if (empty($this->settlement->region_id)) {
                $str .= ', ' . $this->settlement->name;
            } elseif ($this->settlement->region_id == 42) {
                $str .= ', ' . $this->settlement->name;
            } elseif ($this->settlement->region_id == 59) {
                $str .= ', ' . $this->settlement->name;
            } else {
                $type = empty($this->settlement->type_id) ? '' : $this->settlement->type->name;
                $str .= ', ' . $this->settlement->region->name . ', ' . $type . ' ' . $this->settlement->name;
            }

            return $str;
        }
        return $str;
    }

    public function getAssigns()
    {
        $assigns = Yii::app()->authManager->getAuthAssignments($this->id);
        if (empty($assigns))
            return 'user';
        $roles = '';
        foreach ($assigns as $assign) {
            $roles .= $assign->itemName . ', ';
        }
        return trim($roles, ', ');
    }

    public function getRole()
    {
        $assigns = Yii::app()->authManager->getAuthAssignments($this->id);
        if (empty($assigns))
            return 'user';
        foreach (Yii::app()->authManager->getRoles() as $name => $item) {
            if (Yii::app()->authManager->checkAccess($name, $this->id))
                return $name;
        }
        return 'user';
    }

    /**
     * Возвращает приоритет пользователя для окучивания модераторами
     * @return int
     */
    public function getUserPriority()
    {
        //если много пишет, то наивысший приоритет 6
        if (Comment::getUserAvarageCommentsCount($this) > 10)
            return 6;

        //с каждой неделей пребывания на сервере приоритет уменьшается
        $weeks_gone = floor((strtotime(date("Y-m-d H:i:s")) - strtotime($this->register_date)) / 604800);
        switch ($weeks_gone) {
            case 0:
                return 5;
            case 1:
                return 4;
            case 2:
                return 3;
            case 3:
                return 2;
            case 4:
                return 1;
            default:
                return 0;
        }
    }

    public function isNewComer()
    {
        //с каждой неделей пребывания на сервере приоритет уменьшается
        $weeks_gone = floor((strtotime(date("Y-m-d H:i:s")) - strtotime($this->register_date)) / 604800);

        if ($this->getRole() == 'user' && $weeks_gone < 5)
            return true;
        return false;
    }

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
        return $friend->save();
    }

    /**
     * @param $friend_id
     * @return bool
     */
    public function isFriend($friend_id)
    {
        return Friend::model()->count($this->getFriendCriteria($friend_id)) != 0;
    }

    /**
     * @param $friend_id
     * @return bool
     */
    public function delFriend($friend_id)
    {
        return Friend::model()->deleteAll($this->getFriendCriteria($friend_id)) != 0;
    }

    /**
     * @return CActiveDataProvider
     */
    public function getFriends()
    {
        return new CActiveDataProvider('User', array(
            'join' => 'JOIN ' . Friend::model()->tableName() . ' ON (t.id = friends.user1_id AND friends.user2_id = :user_id) OR (t.id = friends.user2_id AND friends.user1_id = :user_id)',
            'params' => array(':user_id' => $this->id),
        ));
    }

    /**
     * @return CActiveDataProvider
     */
    public function getFriendRequests()
    {
        return new CActiveDataProvider('FriendRequest', array(
            'criteria'=>array(
                'condition' => 'from_id = :user_id OR to_id = :user_id',
                'params' => array(':user_id' => Yii::app()->user->id),
                'with' => array('from', 'to'),
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }
}