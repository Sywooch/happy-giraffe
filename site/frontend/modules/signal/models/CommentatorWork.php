<?php

class CommentatorWork extends EMongoDocument
{
    /**
     * Максимальное количество пропусков статей для комментирования
     */
    const MAX_SKIPS = 30;

    /**
     * @var int id комментатора
     */
    public $user_id;
    /**
     * @var CommentatorDayWork[] рабочие дни комментатора
     */
    public $days = array();
    /**
     * @var string сущность для комментирования
     */
    public $comment_entity;
    /**
     * @var int in сущности для комментирования
     */
    public $comment_entity_id;
    /**
     * @var array массив пропущенных страниц, не должны попадаться для комментирования
     */
    public $skipUrls = array();
    /**
     * @var int время начала работы
     */
    public $created;
    /**
     * @var array пользователи темы которых игнорируются при поиске тем для комментирования
     */
    public $ignoreUsers = array();
    /**
     * @var int является ли главным в группе комментаторов
     */
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
                'arrayDocClassName' => 'CommentatorDayWork'
            ),
        );
    }

    public function beforeSave()
    {
        //проверяем статус выполнения плана
        $day = $this->getCurrentDay();
        if ($day) {
            $day->checkStatus($this);
        }

        if ($this->isNewRecord)
            $this->created = time();

        return parent::beforeSave();
    }

    /******************************************************************************************************************/
    /**************************************** Работа пользователя - основное ******************************************/
    /******************************************************************************************************************/

    /**
     * Возвращает текущего комментатора. Если документ в бд для него не создан, создает его
     * @static
     * @return CommentatorWork
     */
    public static function getCurrentUser()
    {
        return self::getOrCreateUser(Yii::app()->user->id);
    }

    /**
     * Возвращает комментатора по id. Если документ в бд для него не создан, создает его
     * @static
     * @param $user_id int id пользователя
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

    /**
     * Возвращает сегодняшний рабочий день, если не работает - null
     * @return CommentatorDayWork|null сегодняшний рабочий день
     */
    public function getCurrentDay()
    {
        $this->getSomeDay(date("Y-m-d"));
    }

    /**
     * Возвращает вчерашний рабочий день, если не работал - null
     * @return CommentatorDayWork|null вчерашний рабочий день
     */
    public function getPrevDay()
    {
        $this->getSomeDay(date("Y-m-d", strtotime('-1 day')));
    }

    /**
     * Возвращает рабочий день за указанную дату, если не работал - null
     * @param $date дата работы
     * @return CommentatorDayWork|null рабочий день
     */
    public function getSomeDay($date)
    {
        foreach ($this->days as $day)
            if ($day->date == $date)
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

    public function IsWorks($day)
    {
        foreach ($this->days as $_day)
            if ($_day->date == $day)
                return true;

        return false;
    }

    /**
     * Создание рабочего дня
     *
     * @return bool
     */
    public function CreateWorkingDay()
    {
        if ($this->getCurrentDay())
            return true;

        $day = new CommentatorDayWork();
        $day->date = date("Y-m-d");
        $day->skip_count = 0;
        $day->created = time();

        $this->days[] = $day;
        $this->calculateNextComment();
        return $this->save();
    }

    /**
     * Вычисление статистики за день
     */
    public function calculateDayStats($date = null)
    {
        if (empty($date)) {
            $prev_day = $this->getPrevDay();
            if ($prev_day !== null)
                $prev_day->calculateStats($this->user_id);
            $current_day = $this->getCurrentDay();
            if ($current_day !== null)
                $current_day->calculateStats($this->user_id);
        } else {
            $day = $this->getSomeDay($date);
            if ($day !== null)
                $day->calculateStats($this->user_id);
        }
    }


    /******************************************************************************************************************/
    /*************************************** Плановые лимиты задач комментатора ***************************************/
    /******************************************************************************************************************/
    public function getCommentsLimit()
    {
        return ($this->chief == 1) ? 60 : 100;
    }

    public function getBlogPostsLimit()
    {
        return ($this->chief == 1) ? 1 : 1;
    }

    public function getClubPostsLimit()
    {
        return ($this->chief == 1) ? 1 : 2;
    }

    /******************************************************************************************************************/
    /************************************************* Комментарии ****************************************************/
    /******************************************************************************************************************/

    /**
     * Увеличивает кол-во выполненных заданий на комментирование на 1 и вычисляет следующий пост для комментирования
     * @param bool $next
     * @return bool
     */
    public function incCommentsCount($next = true)
    {
        $this->getCurrentDay()->comments++;
        if ($next) {
            $this->save();
            if ($this->calculateNextComment()) {
                $this->save();
                return true;
            }
        } else
            return $this->save();

        return false;
    }

    /**
     * Пропуск статьи для комментирования
     *
     * @return bool
     */
    public function skipComment()
    {
        //если достигнут предел дневной нормы пропусков запрещаем пропуск статьи
        if ($this->getCurrentDay()->skip_count >= self::MAX_SKIPS)
            return false;

        if (!empty($this->comment_entity) && !empty($this->comment_entity_id)) {
            if ($this->comment_entity == 'BlogContent')
                $this->comment_entity = 'CommunityContent';
            $this->skipUrls[] = array($this->comment_entity, $this->comment_entity_id);
        }
        $this->save();

        //вычисляем следующий пост для комментирования
        if ($this->calculateNextComment()) {
            $this->getCurrentDay()->skip_count++;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Вычисляет следующий пост (в блоге, в клубах, рецепт) для комментарирования
     */
    public function calculateNextComment()
    {
        //сохраняем время генерации комментария
        TimeLogger::model()->startTimer('next comment');
        $list = PostForCommentator::getNextPost($this);
        TimeLogger::model()->endTimer();

        if ($list === false)
            return false;

        list($this->comment_entity, $this->comment_entity_id) = $list;
        return true;
    }

    /**
     * Ссылка на статью для комментирования, нужно для вьюхи
     *
     * @return CActiveRecord
     */
    public function nextCommentLink()
    {
        if ($this->comment_entity !== 'CookRecipe')
            $model = CActiveRecord::model($this->comment_entity)->resetScope()->full()->findByPk($this->comment_entity_id);
        else
            $model = CActiveRecord::model($this->comment_entity)->resetScope()->findByPk($this->comment_entity_id);

        if ($model->removed) {
            $model->full = 1;
            $model->update(array('full'));
            $model = null;
        }

        if ($model === null) {
            $this->calculateNextComment();
            $this->save();
            $model = CActiveRecord::model($this->comment_entity)->findByPk($this->comment_entity_id);
        }

        $title = empty($model->title) ? $model->getContentText() : $model->title;
        return CHtml::link($title, $model->url, array('target' => '_blank'));
    }

    /**
     * Проверяет не находится ли пост в списке пропущенных комментатором
     *
     * @param $entity
     * @param $entity_id
     * @return bool
     */
    public function IsSkipped($entity, $entity_id)
    {
        foreach ($this->skipUrls as $skipped) {
            if ($skipped[0] == $entity && $skipped[1] == $entity_id)
                return true;
        }

        return false;
    }

    /******************************************************************************************************************/
    /**************************************************** Посты *******************************************************/
    /******************************************************************************************************************/
    /**
     * Возвращает количество постов/комментариев за период
     *
     * @param $entity
     * @param $period
     * @return int|mixed
     */
    public function getEntitiesCount($entity, $period)
    {
        $result = 0;
        foreach ($this->days as $day)
            if (strpos($day->date, $period) === 0)
                $result += $day->$entity;

        return $result;
    }

    public function blogPosts()
    {
        $criteria = new CDbCriteria;
        $criteria->order = 'created desc';

        //return CommunityContent::model()->findAllByPk($criteria);
        return array();
    }

    public function clubPosts()
    {
        return array();
    }

    public function clubPostsCount()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'updated >= :today AND status = ' . SeoTask::STATUS_CLOSED . ' AND multivarka>=1 ';
        $criteria->params = array(':today' => date("Y-m-d") . ' 00:00:00');
        $criteria->compare('executor_id', Yii::app()->user->id);
        $count = SeoTask::model()->count($criteria);

        return $count;
    }


    /******************************************************************************************************************/
    /**************************************************** Премии *******************************************************/
    /******************************************************************************************************************/
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
        return CommentatorHelper::imRating($this->user_id, $month . '-01', $month . '-31');
    }

    public function profileUniqueViews($period)
    {
        $month = CommentatorsMonth::get($period);
        if (isset($month->commentators[(int)$this->user_id][CommentatorsMonth::PROFILE_VIEWS]))
            return $month->commentators[(int)$this->user_id][CommentatorsMonth::PROFILE_VIEWS];

        return 0;
    }

    public function seVisits($period)
    {
        $month = CommentatorsMonth::get($period);
        if (isset($month->commentators[(int)$this->user_id][CommentatorsMonth::SE_VISITS]))
            return $month->commentators[(int)$this->user_id][CommentatorsMonth::SE_VISITS];

        return 0;
    }

    /******************************************************************************************************************/
    /**************************************************** Views *******************************************************/
    /******************************************************************************************************************/
    public function getPlace($period, $counter)
    {
        $month = CommentatorsMonth::get($period);

        $place = $month->getPlace($this->user_id, $counter);
        if ($place == 0) {
            return '<span class="place"></span>';
        } elseif ($place < 4)
            return '<span class="place place-' . $place . '">' . $place . ' место</span>';
        return '<span class="place">' . $place . ' место</span>';
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

    /**
     * @param CommentatorsMonth $current_month
     * @return array
     */
    public function getPosts($current_month)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('author_id', $this->user_id);
        $criteria->order = 'created desc';
        $criteria->with = array('rubric', 'rubric.community', 'type');

        //сортирока по заходам
        $posts = CommunityContent::model()->findAll($criteria);
//        foreach($posts as $post)
//            $post->visits = $current_month->getPageVisitsCount($post->url);
//        usort($posts, array($this, "cmp"));
        return $posts;
    }

    function cmp($a, $b)
    {
        if ($a->visits == $b->visits) {
            return 0;
        }
        return ($a->visits > $b->visits) ? -1 : 1;
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
     * @param string $period
     * @return CommentatorDayWork []
     */
    public function getDays($period)
    {
        $result = array();
        foreach ($this->days as $day)
            if (strpos($day->date, $period) === 0)
                $result[] = $day;

        return array_reverse($result);
    }

    /**
     * @param $working_commentators CommentatorWork[]
     * @param $summary array
     * @param $days_count int
     * @return bool
     */
    public static function isExecuted($working_commentators, $summary, $days_count)
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

    /**
     * @param CommentatorDayWork $day
     * @return CommentatorDayWork|null
     */
    public function getDay($day)
    {
        foreach ($this->days as $_day)
            if ($_day->date == $day)
                return $_day;

        return null;
    }
}
