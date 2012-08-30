<?php

class CommentatorWork extends EMongoDocument
{
    const BLOG_POSTS_COUNT = 1;
    const CLUB_POSTS_COUNT = 2;
    const COMMENTS_COUNT = 100;
    const MAX_SKIPS = 10;

    public $user_id;
    public $clubs;
    /**
     * @var CommentatorDay[]
     */
    public $days = array();
    public $stat;
    public $comment_entity;
    public $comment_entity_id;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'commentator_work';
    }

    public function behaviors()
    {
        return array(
            'embeddedArrays' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'days',
                'arrayDocClassName' => 'CommentatorDay'
            ),
        );
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

    public function IsWorksToday()
    {
        foreach ($this->days as $day)
            if ($day->date == date("Y-m-d"))
                return true;

        return false;
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

        list($this->comment_entity, $this->comment_entity_id) = PostsWithoutCommentsCommentator::getPost();

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

    public function incCommentsCount()
    {
        $this->getCurrentDay()->comments++;
        $this->getCurrentDay()->checkStatus();
        list($this->comment_entity, $this->comment_entity_id) = $this->getNextPost();
        $this->save();
    }

    public function skipComment()
    {
        list($this->comment_entity, $this->comment_entity_id) = $this->getNextPost();
        if ($this->getCurrentDay()->skip_count >= 10)
            return false;

        $this->getCurrentDay()->skip_count++;
        $this->save();
        return true;
    }

    /**
     * получить следующий пост (в блоге, в клубах, рецепт) для комментарирования
     *
     */
    public function getNextPost()
    {
        $rand = rand(0, 99);
        if ($rand < 50)
            return UserPostForCommentator::getPost();
        elseif ($rand < 65)
            return MainPagePostForCommentator::getPost();
        elseif ($rand < 80)
            return SocialPostForCommentator::getPost();
        elseif ($rand < 90)
            return TrafficPostForCommentator::getPost();
        return CoWorkersPostCommentator::getPost();
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
            $model->clubs = array(1, 2, 3, 4);
            $model->save();
        }

        return $model;
    }

    public function blogPosts()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user_id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
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
        $criteria->compare('author_id', $this->user_id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'user_id IS NULL'
            )
        );

        return CommunityContent::model()->findAll($criteria);
    }

    public function clubPostsCount()
    {
        $count = 0;
        foreach ($this->clubPosts() as $post)
            if (in_array($post->rubric->community_id, $this->clubs))
                $count++;

        return $count;
    }

    public function comments()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user_id);
        $criteria->condition = 'created > "' . date("Y-m-d") . ' 00:00:00"';
        $criteria->order = 'created desc';

        return Comment::model()->count($criteria);
    }

    /**
     * @return Community[]
     */
    public function communities()
    {
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
                    'condition' => 'dialogUsers.user_id = ' . $this->user_id
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

        $res = 0;
        foreach ($dialogs as $dialog)
            $res += count($dialog->messages);

        return $res;
    }

    public function blogVisits($period)
    {
        $id = 'blog-visits-' . $this->user_id;
        $value = Yii::app()->cache->get($id);
        if ($value === false) {
            Yii::import('site.frontend.extensions.GoogleAnalytics');
            $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
            $ga->setProfile('ga:53688414');
            $ga->setDateRange($period . '-01', $period . '-31');
            $report = $ga->getReport(array(
                'metrics' => urlencode('ga:visitors'),
                'filters' => urlencode('ga:pagePath=~' . '/user/' . $this->user_id . '/blog/*'),
            ));

            $value = $report['']['ga:visitors'];
            Yii::app()->cache->set($id, $value, 7200);
        }

        return $value;
    }

    public function profileUniqueViews($period)
    {

        $id = 'profile-pageViews-' . $this->user_id;
        $value = Yii::app()->cache->get($id);
        if ($value === false) {
            Yii::import('site.frontend.extensions.GoogleAnalytics');
            $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
            $ga->setProfile('ga:53688414');
            $ga->setDateRange($period . '-01', $period . '-31');
            $report = $ga->getReport(array(
                'metrics' => urlencode('ga:uniquePageviews'),
                'filters' => urlencode('ga:pagePath=~' . '/user/' . $this->user_id . '/'),
            ));

            $value = $report['']['ga:uniquePageviews'];
            Yii::app()->cache->set($id, $value, 7200);
        }

        return $value;
    }

    public function seVisits($period)
    {
        return 0;
    }

    /**
     * @return CActiveRecord
     */
    public function nextComment()
    {
        $model = CActiveRecord::model($this->comment_entity)->findByPk($this->comment_entity_id);

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
        $month = CommentatorsMonthStats::model()->find(new EMongoCriteria(array(
            'conditions' => array(
                'period' => array('==' => $period)
            ),
        )));
        if ($month === null){
            $month = new CommentatorsMonthStats;
            $month->period = $period;
            $month->calculate();
            $month->save();
        }

        $place =  $month->getPlace($this->user_id, $counter);
        if ($place < 4)
            return '<span class="place place-'.$place.'">'.$place.' место</span>';
        return '<span class="place">'.$place.' место</span>';
    }
}
