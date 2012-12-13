<?php

class CommentatorWork extends EMongoDocument
{
    const BLOG_POSTS_COUNT = 1;
    const CLUB_POSTS_COUNT = 2;
    const COMMENTS_COUNT = 100;
    const MAX_SKIPS = 200;

    const CHIEF_BLOG_POSTS_COUNT = 1;
    const CHIEF_CLUB_POSTS_COUNT = 1;
    const CHIEF_COMMENTS_COUNT = 60;

    public $user_id;
    public $clubs = array(1);
    /**
     * @var CommentatorDay[]
     */
    public $days = array();
    public $stat;
    public $comment_entity;
    public $comment_entity_id;
    public $skipUrls = array();
    public $created;
    public $ignoreUsers = array();
    public $chief = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'commentator_work';
    }

    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_production');
    }

    public function behaviors()
    {
        return array(
            'embeddedArrays' => array(
                'class' => 'site.frontend.extensions.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'days',
                'arrayDocClassName' => 'CommentatorDay'
            ),
        );
    }

    public function beforeSave()
    {
        $day = $this->getCurrentDay();
        if (isset($day)) {
            $day->checkStatus($this);
        }

        if ($this->isNewRecord)
            $this->created = time();

        return parent::beforeSave();
    }

    public function getCommentsLimit()
    {
        return ($this->chief == 1) ? self::CHIEF_COMMENTS_COUNT : self::COMMENTS_COUNT;
    }

    public function getBlogPostsLimit()
    {
        return ($this->chief == 1) ? self::CHIEF_BLOG_POSTS_COUNT : self::BLOG_POSTS_COUNT;
    }

    public function getClubPostsLimit()
    {
        return ($this->chief == 1) ? self::CHIEF_CLUB_POSTS_COUNT : self::CLUB_POSTS_COUNT;
    }

    /**
     * @return CommentatorDay
     */
    public function getCurrentDay()
    {
        foreach ($this->days as $day)
            if ($day->date == date("Y-m-d"))
                return $day;

        return null;
    }

    /**
     * @return CommentatorDay
     */
    public function getPreviousDay()
    {
        $max_day = 0;
        foreach ($this->days as $day)
            if (strtotime($day->date) > $max_day && $day->date != date("Y-m-d"))
                $max_day = strtotime($day->date);

        if ($max_day == 0)
            return null;

        foreach ($this->days as $day)
            if (strtotime($day->date) == $max_day)
                return $day;
    }

    /**
     * @param CommentatorDay $day
     * @return CommentatorDay|null
     */
    public function getDay($day)
    {
        foreach ($this->days as $_day)
            if ($_day->date == $day)
                return $_day;

        return null;
    }

    public function IsWorksToday()
    {
        foreach ($this->days as $day)
            if ($day->date == date("Y-m-d"))
                return true;

        return false;
    }

    public function IsWorks($day)
    {
        foreach ($this->days as $_day)
            if ($_day->date == $day)
                return true;

        return false;
    }

    public function getEntitiesCount($entity, $period)
    {
        $result = 0;
        foreach ($this->days as $day)
            if (strpos($day->date, $period) === 0)
                $result += $day->$entity;

        return $result;
    }

    public function WorksToday()
    {
        if ($this->getCurrentDay())
            return true;

        $day = new CommentatorDay();
        $day->date = date("Y-m-d");
        $day->skip_count = 0;
        $day->created = time();
        $day->blog_posts = count($this->blogPosts());
        $day->club_posts = $this->clubPostsCount();

        if (empty($this->days))
            $this->days = array($day);
        else
            $this->days[] = $day;

        $this->getNextPostForComment();

        //add working day
        $month = CommentatorsMonthStats::getOrCreateWorkingMonth();
        $month->workingDays [] = date("Y-m-d");
        $month->save();

        return $this->save();
    }

    public function refreshCurrentDayPosts()
    {
        $day = $this->getCurrentDay();
        if (!empty($day)) {
            $day->blog_posts = count($this->blogPosts());
            $day->club_posts = $this->clubPostsCount();
            $this->save();
        }
    }

    public function incCommentsCount($next = true)
    {
        $this->getCurrentDay()->comments++;
        if ($next) {
            $this->save();
            if ($this->getNextPostForComment()) {
                $this->save();
                return true;
            }
        } else
            return $this->save();

        return false;
    }

    public function skipComment()
    {
        if ($this->getCurrentDay()->skip_count >= self::MAX_SKIPS)
            return false;

        $this->skipArticle();
        $this->save();
        if ($this->getNextPostForComment()) {

            $this->getCurrentDay()->skip_count++;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * получить следующий пост (в блоге, в клубах, рецепт) для комментарирования
     */
    public function getNextPostForComment()
    {
        TimeLogger::model()->startTimer('next comment');
        $list = PostForCommentator::getNextPost($this);
        TimeLogger::model()->endTimer();

        if ($list === false) {
            return false;
        }

        list($this->comment_entity, $this->comment_entity_id) = $list;
        return true;
    }

    public function skipArticle()
    {
        if (empty($this->skipUrls))
            $this->skipUrls = array(array($this->comment_entity, $this->comment_entity_id));
        elseif (!empty($this->comment_entity) && !empty($this->comment_entity_id)) {
            if ($this->comment_entity == 'BlogContent')
                $this->comment_entity = 'CommunityContent';
            $this->skipUrls[] = array($this->comment_entity, $this->comment_entity_id);
        }
    }

    /**
     * @static
     * @return CommentatorWork
     */
    public static function getCurrentUser()
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)Yii::app()->user->id);
        $model = self::model()->find($criteria);
        if ($model === null) {
            $model = new CommentatorWork();
            $model->user_id = (int)Yii::app()->user->id;
            $model->save();
        }

        return $model;
    }

    /**
     * @static
     * @param int $user_id
     * @return CommentatorWork
     */
    public static function getOrCreateUser($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user_id);
        $model = self::model()->find($criteria);
        if ($model === null) {
            $model = new CommentatorWork();
            $model->user_id = (int)$user_id;
            $model->save();
        }

        return $model;
    }

    /**
     * @static
     * @param int $user_id
     * @return CommentatorWork
     */
    public static function getUser($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user_id);
        $model = self::model()->find($criteria);
        return $model;
    }

    public function blogPosts()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->compare('author_id', $this->user_id);
        $criteria->order = 'created desc';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id = ' . $this->user_id
            )
        );

        return CommunityContent::model()->findAll($criteria);
    }

    public function clubPosts()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->compare('author_id', $this->user_id);
        $criteria->order = 'created desc';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id IS NULL'
            )
        );

        return CommunityContent::model()->findAll($criteria);
    }

    public function recipes()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->compare('author_id', $this->user_id);
        $criteria->order = 'created desc';

        return CookRecipe::model()->findAll($criteria);
    }

    public function clubPostsCount()
    {
        $club_id = $this->getCurrentClubId();
        if (empty($club_id))
            return count($this->clubPosts() + $this->recipes());

        //check post in current community
        $count = 0;
        if ($club_id == 22)
            $count = count($this->recipes()) > 0 ? 1 : 0;

        foreach ($this->clubPosts() as $post)
            if ($post->rubric->community_id == $club_id)
                $count = 1;

        Yii::import('site.seo.modules.writing.models.*');
        //check post by keyword
        $criteria = new CDbCriteria;
        $criteria->condition = 'updated >= :today OR status = ' . SeoTask::STATUS_CLOSED;
        $criteria->params = array(':today' => date("Y-m-d") . ' 00:00:00');
        $criteria->compare('executor_id', Yii::app()->user->id);
        $criteria->compare('multivarka', 1);
        $task = SeoTask::model()->find($criteria);

        if ($task !== null)
            $count++;

        return $count;
    }

    public function getCurrentClubId()
    {
        $day = $this->getCurrentDay();
        if (empty($day->today_club)) {
            $this->calcCurrentClub();
            $this->save();
        }

        return $day->today_club;
    }

    public function calcCurrentClub($mode = 0)
    {
        $day = $this->getCurrentDay();
        if ($mode)
            print_r($this->clubs);

        #TODO если нет назначенных клубов, назначается 1-й
        if (empty($this->clubs))
            $this->clubs = array(1);

        $this->clubs = array_values($this->clubs);

        $prev_day = $this->getPreviousDay();
        if ($prev_day == null) {
            if ($mode)
                echo "prev day = null \n";
            $day->today_club = $this->clubs[0];
        } else {
            if (!empty($prev_day->today_club)) {
                for ($i = 0; $i < count($this->clubs); $i++) {
                    if ($this->clubs[$i] == $prev_day->today_club) {
                        if (isset($this->clubs[$i + 1]))
                            $day->today_club = $this->clubs[$i + 1];
                        else
                            $day->today_club = $this->clubs[0];
                    }
                }
            } else
                $day->today_club = $this->clubs[0];

            if ($mode)
                echo "today club = $day->today_club \n";
        }
    }

    public function comments()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->compare('author_id', $this->user_id);
        $criteria->order = 'created desc';

        return Comment::model()->count($criteria);
    }

    /**
     * @return Community[]
     */
    public function communities()
    {
        if (empty($this->clubs))
            return array();

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->clubs);
        return Community::model()->findAll($criteria);
    }

    public function getWorkingMonths()
    {
        $result = array();
        foreach ($this->days as $day) {
            $date = date("Y-m", $day->created);
            if (!in_array($date, $result))
                $result[] = $date;
        }

        return array_reverse($result);
    }

    public function newFriends($month)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = '(user1_id = :user_id OR user2_id = :user_id) AND created >= :min AND created <= :max ';
        $criteria->params = array(
            ':user_id' => $this->user_id,
            ':min' => $month . '-01 00:00:00',
            ':max' => $month . '-31 23:59:59'
        );
        return Friend::model()->count($criteria);
    }

    public function imMessages($month)
    {
        $dialogs = Dialog::model()->findAll(array(
            'with' => array(
                'dialogUsers' => array(
                    'condition' => 'dialogUsers.user_id = ' . $this->user_id,
                ),
                'messages' => array(
                    'condition' => 'messages.created >= :min AND messages.created <= :max',
                    'params' => array(
                        ':min' => $month . '-01 00:00:00',
                        ':max' => $month . '-31 23:59:59'
                    )
                ),
                'together' => true
            )
        ));

        $rating = 0;
        $dialogs_count = 1;
        foreach ($dialogs as $dialog) {
            //если переписка ведется с простым пользователем
            if ($dialog->withSimpleUser()) {
                $user_answered = false;
                foreach ($dialog->messages as $message)
                    if ($message->user_id == $this->user_id)
                        $rating += 0.2;
                    else {
                        $rating += 1;
                        $user_answered = true;
                    }

                if ($user_answered)
                    $dialogs_count = $dialogs_count * 1.01;
            }
        }

        return round($rating * $dialogs_count);
    }

    public function blogVisits($period)
    {
        $month = CommentatorsMonthStats::getOrCreateWorkingMonth($period);
        if (isset($month->commentators[(int)$this->user_id][CommentatorsMonthStats::BLOG_VISITS]))
            return $month->commentators[(int)$this->user_id][CommentatorsMonthStats::BLOG_VISITS];

        return 0;
    }

    public function profileUniqueViews($period)
    {
        $month = CommentatorsMonthStats::getOrCreateWorkingMonth($period);
        if (isset($month->commentators[(int)$this->user_id][CommentatorsMonthStats::PROFILE_UNIQUE_VIEWS]))
            return $month->commentators[(int)$this->user_id][CommentatorsMonthStats::PROFILE_UNIQUE_VIEWS];

        return 0;
    }

    public function seVisits($period)
    {
        $month = CommentatorsMonthStats::getOrCreateWorkingMonth($period);
        if (isset($month->commentators[(int)$this->user_id][CommentatorsMonthStats::SE_VISITS]))
            return $month->commentators[(int)$this->user_id][CommentatorsMonthStats::SE_VISITS];

        return 0;
    }

    /**
     * @return CActiveRecord
     */
    public function nextComment()
    {
        $model = CActiveRecord::model($this->comment_entity)->findByPk($this->comment_entity_id);
        if ($model === null) {
            $this->getNextPostForComment();
            $this->save();
            $model = CActiveRecord::model($this->comment_entity)->findByPk($this->comment_entity_id);
        }

        return CHtml::link($model->title, $model->url, array('target' => '_blank'));
    }

    /**
     * @param string $period
     * @return CommentatorDay []
     */
    public function getDays($period)
    {
        $result = array();
        foreach ($this->days as $day)
            if (strpos($day->date, $period) === 0)
                $result[] = $day;

        return array_reverse($result);
    }

    public function getPlace($period, $counter)
    {
        $month = CommentatorsMonthStats::getOrCreateWorkingMonth($period);

        $place = $month->getPlace($this->user_id, $counter);
        if ($place == 0) {
            return '<span class="place"></span>';
        } elseif ($place < 4)
            return '<span class="place place-' . $place . '">' . $place . ' место</span>';
        return '<span class="place">' . $place . ' место</span>';
    }

    public function getStatusView($period)
    {
        return '<td></td>';
    }

    public function isNotWorkingAlready()
    {
        $auth_item = Yii::app()->db->createCommand()
            ->select('itemname')
            ->from('auth__assignments')
            ->where('itemname = "commentator" AND userid = ' . $this->user_id)
            ->queryScalar();
        return empty($auth_item);

    }

    public function getName()
    {
        return User::getUserById($this->user_id)->fullName;
    }

    public function getPosts($period)
    {
        //$last_day = $this->getLastPeriodDay($period);
        $criteria = new CDbCriteria;
        //$criteria->condition = 'created >= "' . $period . '-01 00:00:00" AND created <= "' . $period . '-' . $last_day . ' 23:59:59"';
        $criteria->compare('author_id', $this->user_id);
        $criteria->order = 'created desc';
        $criteria->with = array('rubric', 'rubric.community', 'type');

        return CommunityContent::model()->findAll($criteria);
    }

    public function getLastPeriodDay($period)
    {
        return str_pad(cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($period)), date('Y', strtotime($period))), 2, "0", STR_PAD_LEFT);
    }

    public function skipped($url)
    {
        return in_array($url, $this->skipUrls);
    }

    public function getCommentatorGroups()
    {
        $criteria = new EMongoCriteria();
        $criteria->sort('created', EMongoCriteria::SORT_ASC);
        $models = CommentatorWork::model()->findAll($criteria);

        return $models;
    }

    /**
     * @return CommentatorWork[]
     */
    public static function getWorkingCommentators()
    {
        $criteria = new EMongoCriteria();
        $criteria->sort('created', EMongoCriteria::SORT_ASC);
        $models = CommentatorWork::model()->findAll($criteria);
        foreach ($models as $k => $model)
            if ($model->isNotWorkingAlready()) {
                unset($models[$k]);
            }

        return $models;
    }

    /**
     * @param $working_commentators CommentatorWork[]
     * @param $summary array
     * @param $days_count int
     * @return bool
     */
    public static function getExecutedStatus($working_commentators, $summary, $days_count)
    {
        $summary_comment_limit = 0;
        foreach ($working_commentators as $commentator)
            $summary_comment_limit += $commentator->getCommentsLimit();

        $summary_club_limit = 0;
        foreach ($working_commentators as $commentator)
            $summary_club_limit += $commentator->getClubPostsLimit();

        $summary_blog_limit = 0;
        foreach ($working_commentators as $commentator)
            $summary_blog_limit += $commentator->getBlogPostsLimit();

        if ($summary[0] / count($working_commentators) >= $summary_blog_limit * $days_count
            && $summary[1] / count($working_commentators) >= $summary_club_limit * $days_count
            && $summary[2] / count($working_commentators) >= $summary_comment_limit * $days_count
        )
            return true;

        return false;
    }
}
