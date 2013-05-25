<?php

/**
 * This is the model class for table "score__achievements".
 *
 * The followings are the available columns in table 'score__achievements':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $count
 * @property string $parent_id
 * @property integer $scores
 *
 * The followings are the available model relations:
 * @property ScoreAchievement $parent
 * @property ScoreAchievement $next
 * @property User[] $users
 */
class ScoreAchievement extends HActiveRecord
{
    const TYPE_BLOG = 1;
    const TYPE_DAY_POSTS = 4;
    const TYPE_COMMENTS = 7;
    const TYPE_FRIENDS = 10;
    const TYPE_VIDEO = 13;
    const TYPE_VIEWS = 16;
    const TYPE_ALBUMS = 19;
    const TYPE_DUELS = 22;
    const TYPE_CLUB_POSTS = 25;
    const TYPE_PHOTO = 28;
    const TYPE_YOHOHO = 31;
    const TYPE_VISITOR = 34;

    public $user_id = null;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScoreAchievement the static model class
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
        return 'score__achievements';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('scores', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('count, parent_id', 'length', 'max' => 10),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, count, parent_id, scores', 'safe', 'on' => 'search'),
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
            'parent' => array(self::BELONGS_TO, 'ScoreAchievement', 'parent_id'),
            'next' => array(self::HAS_ONE, 'ScoreAchievement', 'parent_id'),
            'users' => array(self::MANY_MANY, 'User', 'score__user_achievements(achievement_id, user_id)'),
//            'some_users' => array(self::MANY_MANY, 'User', 'score__user_achievements(achievement_id, user_id)', 'limit' => 5),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'title',
            'description' => 'Description',
            'count' => 'Count',
            'parent_id' => 'Parent',
            'scores' => 'Scores',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('count', $this->count, true);
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('scores', $this->scores);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array
     */
    public function getAchieveData()
    {
        $this->user_id = Yii::app()->user->id;
        $itemsCount = $this->itemsCount();
        $level_count = isset($this->parent) ? ($this->count - $this->parent->count) : $this->count;
        $percents = round(100 * $itemsCount / $level_count);
        if ($percents > 100)
            $percents = 100;

        return array($itemsCount, $level_count, $percents);
    }

    /*********************************** Количество выполненных заданий достижения ***********************************/

    /**
     * @return int
     */
    public function itemsCount()
    {
        switch ($this->id) {
            case 1:
            case 2:
            case 3:
                return $this->user()->blogPostsCount;
            case 4:
            case 5:
            case 6:
                return $this->getTodayPostsCount();
            case 7:
            case 8:
            case 9:
                return $this->user()->commentsCount;
            case 10:
            case 11:
            case 12:
                return $this->user()->getFriendsCount();
            case 13:
            case 14:
            case 15:
                return $this->getVideoPostsCount();
            case 16:
            case 17:
            case 18:
                return $this->getViewedPostsCount();
            case 19:
            case 20:
            case 21:
                return $this->user()->albumsCount;
            case 22:
            case 23:
            case 24:
                return $this->user()->answersCount;
            case 25:
            case 26:
            case 27:
                return $this->user()->communityPostsCount;
            case 28:
            case 29:
            case 30:
                return $this->getPhotoCount();
            case 31:
            case 32:
            case 33:
                return $this->getValueCount();
            case 34:
            case 35:
            case 36:
                return $this->getRunningVisitsCount();
            default:
                return 0;
        }
    }

    /**
     * @return User
     */
    public function user()
    {
        return User::getUserById($this->user_id);
    }

    public function getTodayPostsCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->compare('author_id', $this->user_id);
        $criteria->scopes = array('active');

        return CommunityContent::model()->count($criteria);
    }

    public function getVideoPostsCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user_id);
        $criteria->compare('type_id', 2);
        $criteria->scopes = array('active');

        return CommunityContent::model()->count($criteria);
    }

    public function getViewedPostsCount()
    {
        return UserViewedPost::model()->count('user_id=' . $this->user_id);
    }

    public function getPhotoCount()
    {
        $criteria = new CDbCriteria;
        $criteria->scopes = array('active');
        $criteria->compare('t.author_id', $this->user_id);
        $criteria->with = array(
            'album' => array(
                'condition' => 'type=0 OR type=1 OR type=3',
            )
        );

        return AlbumPhoto::model()->count($criteria);
    }

    public function getValueCount()
    {
        $criteria = new EMongoCriteria();
        $criteria->user_id('==', (int)$this->user_id);

        return RatingYohoho::model()->count($criteria);
    }

    public function getRunningVisitsCount()
    {
        return ScoreVisits::getModel($this->user_id)->current_long_days;
    }


    /***************************************** Проверка на получение достижения ***************************************/

    public function checkAchieve($user_id, $type)
    {
        $achieve = $this->getAchieve($user_id, $type);
        if ($achieve === null)
            return true;

        $achieve->user_id = $user_id;
        //echo $achieve->id . "\n";

        $count = $achieve->itemsCount();
        $level_count = $achieve->count;

        if ($count >= $level_count) {
            //выдать приз
            $value = Yii::app()->db->createCommand()
                ->insert('score__user_achievements', array(
                'user_id' => $user_id,
                'achievement_id' => $achieve->id,
                'created' => date("Y-m-d"),
            ));

            if ($value)
                ScoreInput::model()->add($user_id, ScoreInput::SCORE_ACTION_ACHIEVEMENT, array('achieve_id' => $achieve->id));

            //если есть предыдущая степень достижения, удалить
            if ($value && isset($achieve->parent_id)) {
                Yii::app()->db->createCommand()
                    ->delete('score__user_achievements', 'achievement_id = :achievement_id AND user_id = :user_id',
                    array(
                        ':achievement_id' => $achieve->parent_id,
                        ':user_id' => $user_id
                    ));
            }

            return $value;
        }

        return false;
    }

    public static function addAchieve($user_id, $achieve_id)
    {
        //проверяем есть ли уже
        $exist = Yii::app()->db->createCommand()
            ->select('count(achievement_id)')
            ->from('score__user_achievements')
            ->where('user_id = ' . $user_id . ' AND achievement_id = ' . $achieve_id)
            ->queryScalar();

        if (!$exist) {
            //выдать приз
            $value = Yii::app()->db->createCommand()
                ->insert('score__user_achievements', array(
                'user_id' => $user_id,
                'achievement_id' => $achieve_id,
                'created' => date("Y-m-d"),
            ));

            if ($value)
                ScoreInput::model()->add($user_id, ScoreInput::SCORE_ACTION_ACHIEVEMENT, array('achieve_id' => $achieve_id));
        }
    }

    /**
     * @param $user_id
     * @param $root_id
     * @return ScoreAchievement
     */
    public function getAchieve($user_id, $root_id)
    {
        $this->user_id = $user_id;
        $userAchieves = $this->user()->achievements;

        foreach ($userAchieves as $userAchieve) {
            $parent = $userAchieve;
            while (!empty($parent->parent_id))
                $parent = $parent->parent;

            if ($root_id == $parent->id) {
                return isset($userAchieve->next) ? $userAchieve->next : null;
            }
        }

        return ScoreAchievement::model()->findByPk($root_id);
    }

    /***************************************** Общие методы ***************************************/

    public static function getAchievesCount($user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(achievement_id)')
            ->from('score__user_achievements')
            ->where('user_id = :user_id')
            ->queryScalar(array(':user_id' => $user_id));
    }

    /**
     * @return ScoreAchievement
     */
    public function root()
    {
        if (!empty($this->parent_id))
            return $this->parent->root();
        return $this;
    }

    /**
     * @return ScoreAchievement[]
     */
    public function roots()
    {
        return ScoreAchievement::model()->cache(3600)->findAll('parent_id IS NULL order by id asc');
    }

    public function getRandomUsers()
    {
        $userIds = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('score__user_achievements')
            ->where('achievement_id = :achievement_id', array(':achievement_id' => $this->id))
            ->limit(10)
            ->queryColumn();

        return User::model()->findAllByPk($userIds);
    }

}