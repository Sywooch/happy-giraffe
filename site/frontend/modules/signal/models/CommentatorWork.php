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
    public $days;
    public $stat;

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
     * @return null|User
     */
    public function getUser()
    {
        if (!empty($this->user_id))
            return User::getUserById($this->user_id);
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
        $day = new CommentatorDay();
        $day->date = date("Y-m-d");
        $day->skip_count = 0;
        $day->created = time();
        $this->days[] = $day;

        return $this->save();
    }

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


    public function friendsCount($month)
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

    public function getMessagesCount($month)
    {
        $dialogs = Dialog::model()->findAll(array(
            'with'=>array(
                'dialogUsers'=>array(
                    'condition'=>'dialogUsers.user_id = '.$this->user_id
                ),
                'messages'=>array(
                    'condition'=>'messages.created >= :min AND messages.created <= :max',
                    'params'=>array(
                        ':min' => $month . '-01 00:00:00',
                        ':max' => $month . '-31 23:59:59'
                    )
                ),
                'together'=>true
            )
        ));

        $res = 0;
        foreach($dialogs as $dialog)
            $res += count($dialog->messages);

        return $res;
    }

    public function blogVisits($period)
    {
        $id = 'blog-visits-'.$this->user_id;
        $value=Yii::app()->cache->get($id);
        if($value===false)
        {
            Yii::import('site.frontend.extensions.GoogleAnalytics');
            $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
            $ga->setProfile('ga:53688414');
            $ga->setDateRange($period. '-01', $period.'-31');
            $report = $ga->getReport(array(
                'metrics'=>urlencode('ga:visitors'),
                'filters'=>urlencode('ga:pagePath=~' . '/user/'.$this->user_id.'/blog/*'),
            ));

            $value = $report['']['ga:visitors'];
            Yii::app()->cache->set($id,$value, 7200);
        }

        return $value;
    }

    public function profileUniqueViews($period)
    {

        $id = 'profile-pageViews-'.$this->user_id;
        $value=Yii::app()->cache->get($id);
        if($value===false)
        {
            Yii::import('site.frontend.extensions.GoogleAnalytics');
            $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
            $ga->setProfile('ga:53688414');
            $ga->setDateRange($period. '-01', $period.'-31');
            $report = $ga->getReport(array(
                'metrics'=>urlencode('ga:uniquePageviews'),
                'filters'=>urlencode('ga:pagePath=~' . '/user/'.$this->user_id.'/'),
            ));

            $value = $report['']['ga:uniquePageviews'];
            Yii::app()->cache->set($id,$value, 7200);
        }

        return $value;
    }
}
