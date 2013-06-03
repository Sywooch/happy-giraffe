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
     * Кол-во баллов набранных в достижении
     *
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
                return $this->user()->activeCommentsCount;
            case 10:
            case 11:
            case 12:
                return Friend::model()->getCountByUserId($this->user_id);
            case 13:
            case 14:
            case 15:
                return $this->getVideoPostsCount();
            case 16:
            case 17:
            case 18:
                return UserPostView::getInstance()->count($this->user_id);
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
                return RatingYohoho::model()->countByUser($this->user_id);
            case 34:
            case 35:
            case 36:
                return ScoreVisits::getInstance()->daysCount($this->user_id);
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

    /**
     * Общее кол-во постов за сегодня
     *
     * @return int
     */
    public function getTodayPostsCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->compare('author_id', $this->user_id);
        $criteria->scopes = array('active');

        return CommunityContent::model()->count($criteria);
    }

    /**
     * Кол-во видео выложенных за все время
     *
     * @return int
     */
    public function getVideoPostsCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user_id);
        $criteria->compare('type_id', 2);
        $criteria->scopes = array('active');

        return CommunityContent::model()->count($criteria);
    }

    /**
     * Кол-во фото выложенных за все время
     * @return int
     */
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


    /***************************************** Проверка и получение достижения ***************************************/
    /**
     * Проверить выполнил ли достижение, если выполнил, то выдать его
     *
     * @param int $user_id id пользователя
     * @param int $type тип достижения
     * @return bool|int
     */
    public function checkAchieve($user_id, $type)
    {
        $achieve = $this->getAchieve($user_id, $type);
        if ($achieve === null)
            return true;

        $achieve->user_id = $user_id;
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
                ScoreInputAchievement::getInstance()->add($user_id, $achieve);
            return $value;
        }

        return false;
    }

    /**
     * Возвращает актуальное для пользователя в данный момент достижение
     *
     * @param int $user_id
     * @param int $root_id начальное достижение
     * @return ScoreAchievement
     */
    public function getAchieve($user_id, $root_id)
    {
        $userAchieves = Yii::app()->db->createCommand()
            ->select('achievement_id')
            ->from('score__user_achievements')
            ->where('user_id = :user_id AND achievement_id IN (' . implode(',', array($root_id, $root_id + 1, $root_id + 2)) . ')', array(':user_id' => $user_id))
            ->queryColumn();
        if (empty($userAchieves))
            return ScoreAchievement::model()->findByPk($root_id);

        $achieve = ScoreAchievement::model()->findByPk(max($userAchieves));
        return $achieve->next;
    }

    /**
     * Трофеи автору за просмотры его поста
     *
     * @param CommunityContent $content_model
     * @param int $old_views
     * @param int $now_views
     * @return void
     */
    public static function checkPageViews($content_model, $old_views, $now_views)
    {
        if ($content_model->author_id == User::HAPPY_GIRAFFE || empty($content_model->author_id))
            return;

        $award_levels = array(
            11 => 1000, //трофей "Заметный пост"
            12 => 2500, //трофей "Известный пост"
            13 => 10000, //трофей "Знаменитый пост"
        );

        foreach ($award_levels as $award_id => $award_limit) {

            //если перешел рубеж трофея
            if ($old_views < $award_limit && $now_views >= $award_limit) {

                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //на всякий случай проверяем есть ли уже такой трофей
                    $exist = ScoreUserAward::model()->findByAttributes(array(
                        'award_id' => $award_id,
                        'user_id' => $content_model->author_id,
                        'entity' => get_class($content_model),
                        'entity_id' => $content_model->id,
                    ));
                    //если нет - выдаем
                    if ($exist === null) {
                        $award = new ScoreUserAward();
                        $award->award_id = $award_id;
                        $award->user_id = $content_model->author_id;
                        $award->entity = get_class($content_model);
                        $award->entity_id = $content_model->id;
                        $award->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }

            if ($now_views < $award_limit)
                break;
        }
    }

    /**
     * Трофеи автору за лайки к его посту
     *
     * @param $entity
     * @param int $entity_id
     * @return void
     */
    public static function checkPageLikes($entity, $entity_id)
    {
        //даем только за посты
        if ($entity !== 'CommunityContent' && $entity !== 'BlogContent')
            return;

        $content_model = CActiveRecord::model($entity)->findByPk($entity_id);
        if ($content_model === null || $content_model->author_id == User::HAPPY_GIRAFFE || empty($content_model->author_id))
            return;

        $award_levels = array(
            14 => 10, //трофей "Хороший пост"
            15 => 25, //трофей "Интересный пост"
            16 => 100, //трофей "Превосходный пост"
        );

        foreach ($award_levels as $award_id => $award_limit) {
            $criteria = new EMongoCriteria;
            $criteria->entity_id('==', (int)$entity_id);
            $criteria->entity_name('==', $entity);
            $count = RatingYohoho::model()->count($criteria);

            //если перешел рубеж трофея
            if ($count >= $award_limit) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //на всякий случай проверяем есть ли уже такой трофей
                    $exist = ScoreUserAward::model()->findByAttributes(array(
                        'award_id' => $award_id,
                        'user_id' => $content_model->author_id,
                        'entity' => get_class($content_model),
                        'entity_id' => $content_model->id,
                    ));
                    //если нет - выдаем
                    if ($exist === null) {
                        $award = new ScoreUserAward();
                        $award->award_id = $award_id;
                        $award->user_id = $content_model->author_id;
                        $award->entity = get_class($content_model);
                        $award->entity_id = $content_model->id;
                        $award->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            } else
                break;
        }
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