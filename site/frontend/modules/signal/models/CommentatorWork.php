<?php

/**
 * Class CommentatorWork
 *
 * Description
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
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
        return $this->getSomeDay(date("Y-m-d"));
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
     * @param $date string дата работы
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
     * Вычисление статистики за день. Если передается дата, то за эту дату, если нет то за текущий и предыдущий день
     * @param null|string $date дата
     */
    public function calculateDayStats($date = null)
    {
        if (empty($date)) {
            //если дата не указана - то за текущий и предыдущий день
            $prev_day = $this->getPrevDay();
            if ($prev_day !== null)
                $prev_day->calculateStats($this->user_id);

            $current_day = $this->getCurrentDay();
            if ($current_day !== null)
                $current_day->calculateStats($this->user_id);
        } else {
            //если дата указана - за эту дату
            $day = $this->getSomeDay($date);
            if ($day !== null)
                $day->calculateStats($this->user_id);
        }

        $this->save();
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
     * Проверить комментарий на предмет выполненного задания по комментированию. Если задание выполнено,
     * посылается сигнал через comet-server для обновления панели. Если задание не выполнено, но комментарий
     * засчитан, то также посылается сигнал но без данных о новом комментарии
     *
     * @param $comment комментарий текущего комментатора
     */
    public function checkComment($comment)
    {
        $entity = ($comment->entity == 'BlogContent') ? 'CommunityContent' : $comment->entity;
        $_entity = ($this->comment_entity == 'BlogContent') ? 'CommunityContent' : $this->comment_entity;
        $model = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);

        if ($_entity == $entity && $this->comment_entity_id == $comment->entity_id) {
            $this->incCommentsCount(true);
            $next_comment = $this->getNextComment();

            $comet = new CometModel;
            $comet->send(Yii::app()->user->id, array(
                'inc' => 1,
                'url' => $next_comment->url,
                'title' => $next_comment->title
            ), CometModel::TYPE_COMMENTATOR_NEXT_COMMENT);

        } elseif (!empty($comment->response_id) || (isset($model->author_id) && $model->author_id == $comment->author_id)) {
            $this->incCommentsCount(false);
            $comet = new CometModel;
            $comet->send(Yii::app()->user->id, array(
                'inc' => 1
            ), CometModel::TYPE_COMMENTATOR_NEXT_COMMENT);

        }
    }

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
     * @return CommunityContent
     */
    public function getNextComment()
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

        if (empty($model->title))
            $model->title = $model->getContent()->text;

        return $model;
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

    /**
     * Возвращает текущие задания комментатора в блоги
     * @return SeoTask[]
     */
    public function blogPosts()
    {
        return $this->getTasks(0);
    }

    /**
     * Возвращает текущие задания комментатора в клубы
     * @return SeoTask[]
     */
    public function clubPosts()
    {
        return $this->getTasks(1);
    }

    /**
     * Возвращает текущие задания комментатора для заданной секции - те которые в процессе выполнения +
     * которые выполнил сегодня
     * @param $section int секция в которой ищем задания (0 - в блог, 1- в клуб)
     * @return SeoTask[] задания комментатора
     */
    public function getTasks($section)
    {
        $tasks = SeoTask::model()->findAll($this->getPostsCriteria($section));
        return $this->getTasksView($tasks);
    }

    /**
     * Преобразует массив заданий в массив для передачи в js-код
     * @param $tasks SeoTask[] массив заданий
     * @return array массив для передачи в js-код
     */
    public static function getTasksView($tasks)
    {
        $result = array();
        foreach ($tasks as $task) {
            $keyword = $task->getKeyword();
            $arr = array(
                'id' => $task->id,
                'closed' => ($task->status == SeoTask::STATUS_CLOSED) ? 1 : 0,
                'keyword' => $keyword->name,
                'keyword_id' => $keyword->id,
                'keyword_wordstat' => $keyword->wordstat,
                'article_title' => '',
                'article_url' => '',
            );
            if ($task->status == SeoTask::STATUS_CLOSED) {
                $article = $task->article->getArticle();
                $arr['article_title'] = $article->title;
                $arr['article_url'] = $article->url;
            }

            $result [] = $arr;
        }

        return $result;
    }

    /**
     * Возвращает criteria для выбора заданий комментатора - те которые в процессе выполнения +
     * которые выполнил сегодня
     * @param $section int секция в которой ищем задания (0 - в блог, 1- в клуб)
     * @return CDbCriteria criteria для выбора заданий комментатора
     */
    private function getPostsCriteria($section)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = '((updated >= :today AND status = ' . SeoTask::STATUS_CLOSED . ')
        OR status != ' . SeoTask::STATUS_CLOSED . ') AND sub_section = :section AND executor_id = :user_id';
        $criteria->params = array(
            ':today' => date("Y-m-d") . ' 00:00:00',
            ':section' => $section,
            ':user_id' => Yii::app()->user->id
        );

        return $criteria;
    }

    /******************************************************************************************************************/
    /**************************************************** Задачи от редакции *******************************************************/
    /******************************************************************************************************************/
    /**
     * Возвращает список активных задач редакции для комментаторов
     * @return CommentatorTask[]
     */
    public function getEditorTasks()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created > :today';
        $criteria->params = array(':today' => date("Y-m-d") . ' 00:00:00');
        return CommentatorTask::model()->findAll($criteria);
    }

    /**
     * Возвращает список активных задач редакции для комментаторов для выгрузки в js
     * @return array
     */
    public function getEditorTasksForView()
    {
        $tasks = $this->getEditorTasks();
        $result = array();
        foreach ($tasks as $task) {
            $article = $task->page->getArticle();
            $result [] = array(
                'id' => $task->id,
                'type' => $task->type,
                'closed' => $task->isExecutedByCurrentUser(),
                'article_url' => $article->getUrl(),
                'article_title' => $article->title,
            );
        }

        return $result;
    }

    /**
     * проверяем сущность на выполнение задания
     *
     * @param $entity
     * @param $entity_id
     * @param $type
     */
    public function checkEditorTaskExecuting($entity, $entity_id, $type)
    {
        $page = Page::model()->findByAttributes(array('entity' => $entity, 'entity_id' => $entity_id));
        if ($page !== null) {
            $task = CommentatorTask::model()->findByAttributes(array('page_id' => $page->id, 'type' => $type));
            if ($task !== null) {
                if ($task->isExecutedByCurrentUser()) {
                    $comet = new CometModel;
                    $comet->send(Yii::app()->user->id, array(
                        'task_id' => $task->id
                    ), CometModel::TYPE_COMMENTATOR_UPDATE_TASK);
                }
            }
        }
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
    /**************************************************** Links *******************************************************/
    /******************************************************************************************************************/
    /**
     * Возвращает все ссылки, проставленные в этом месяце
     * @param $month
     * @return CommentatorLink[] ссылки, проставленные в этом месяце
     */
    public function GetLinks($month)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'created >= :first_day AND created <= :last_day';
        $criteria->params = array(
            ':first_day'=>$month.'-01 00:00:00',
            ':last_day'=>$month.'-31 23:59:59',
        );
        $criteria->compare('user_id', $this->user_id);
        $criteria->order = 'id desc';
        return CommentatorLink::model()->findAll($criteria);
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
