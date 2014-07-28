<?php
/**
 * Class ScoreInput
 *
 * Начисление баллов пользователям
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInput extends HMongoModel
{
    public function attributeNames()
    {
        return array();
    }

    /**
     * Что выводим пользователю
     */
    const SELECT_ALL = 0;
    const SELECT_ACTIVITY = 1;
    const SELECT_ACHIEVEMENTS = 2;
    const SELECT_AWARDS = 3;

    /**
     * уведомлений на странице
     */
    const PAGE_SIZE = 20;

    /**
     * Типы уведомлений
     */
    const TYPE_FIRST_BLOG_RECORD = 1;
    const TYPE_POST_ADDED = 2;
    const TYPE_VIDEO = 3;

    const TYPE_FRIEND_ADDED = 4;

    const TYPE_COMMENT_ADDED = 5;
    const TYPE_PHOTOS_ADDED = 6;

    const TYPE_VISIT = 7;

    const TYPE_DUEL_PARTICIPATION = 8;
    const TYPE_DUEL_WIN = 9;

    const TYPE_CONTEST_PARTICIPATION = 10;
    const TYPE_CONTEST_WIN = 11;
    const TYPE_CONTEST_2_PLACE = 12;
    const TYPE_CONTEST_3_PLACE = 13;
    const TYPE_CONTEST_4_PLACE = 14;
    const TYPE_CONTEST_5_PLACE = 15;

    const TYPE_AWARD = 100;
    const TYPE_ACHIEVEMENT = 101;

    protected $_collection_name = 'score_input_new';

    /**
     * @var int id пользователя
     */
    public $user_id;
    /**
     * @var int За что начислили баллы
     */
    public $type;
    /**
     * @var int Кол-во начисленных баллов
     */
    public $scores;
    /**
     * @var int время последнего обновления
     */
    public $updated;
    /**
     * @var int время создания уведомления
     */
    public $created;
    /**
     * @var bool прочитано ли сообщение о начислении баллов
     */
    public $read;
    /**
     * @var bool открыто ли уведомления для дополнительных начислений
     */
    public $closed;


    /**
     * @var ScoreInput
     */
    private static $_instance;

    /**
     * @return ScoreInput
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    /**
     * Добавляет индекс если не создан
     */
    public function ensureIndex()
    {
        $this->getCollection()->ensureIndex(array(
            'user_id' => EMongoCriteria::SORT_DESC,
            'updated' => EMongoCriteria::SORT_DESC,
            'type' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'find_one_index'));

        $this->getCollection()->ensureIndex(array(
            'user_id' => EMongoCriteria::SORT_DESC,
            'updated' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'list_index'));

        $this->getCollection()->ensureIndex(array(
            'created' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'created_index'));
    }

    protected function sendSignal($scores)
    {
        $comet = new CometModel;
        $comet->send($this->user_id, array('scores' => $scores), CometModel::TYPE_SCORES_EARNED);
    }

    /**
     * Создаение нового уведомления о получении баллов
     *
     * @param $specific_fields array массив специфических полей уведомления
     * @param bool $close добавлять ли баллы сразу
     */
    protected function insert($specific_fields = array(), $close = true)
    {
        $this->getCollection()->insert(
            array_merge(array(
                'type' => (int)$this->type,
                'user_id' => (int)$this->user_id,
                'scores' => $this->getScores(),
                'updated' => time(),
                'read' => 0,
                'created' => time(),
                'closed' => (bool)$close
            ), $specific_fields)
        );

        if ($close)
            $this->addScores();
    }

    /**
     * Удаление уведомления о получении баллов, происходит если он удалил то, за что получил баллы
     * Удаляет только одно уведомление
     *
     * @param array $specific_fields массив специфических полей уведомления
     */
    protected function remove($specific_fields = array())
    {
        //ищем соответствующую запись, чтобы проверить нужно ли вычитать баллы
        $model = $this->getCollection()->findOne(
            array_merge(array(
                'type' => (int)$this->type,
                'user_id' => (int)$this->user_id,
            ), $specific_fields)
        );

        //если нашли - удаляем и вычитаем баллы
        if ($model !== null) {
            $this->getCollection()->remove(array('_id' => $model['_id']));
            $this->removeScores();
        }
    }

    /**
     * Возвращает количество баллов за действия
     *
     * @param int $count кол=во прибавлений
     * @return int
     */
    protected function getScores($count = 1)
    {
        if (empty($this->scores))
            $this->scores = $count * ScoreAction::getActionScores($this->type);
        return (int)$this->scores;
    }

    /**
     * Добавление баллов пользователю
     */
    protected function addScores()
    {
        Yii::app()->db->createCommand()->update(UserScores::model()->tableName(),
            array('scores' => new CDbExpression('scores+ :scores', array(':scores' => $this->getScores()))),
            'user_id=:user_id', array(':user_id' => $this->user_id)
        );
    }

    /**
     * Вычитание баллов у пользователя
     */
    protected function removeScores()
    {
        Yii::app()->db->createCommand()->update(UserScores::model()->tableName(),
            array('scores' => new CDbExpression('scores- :scores', array(':scores' => $this->getScores()))),
            'user_id=:user_id', array(':user_id' => $this->user_id)
        );
    }

    /**
     * Возвращает список уведомлений о начислении баллов
     *
     * @param int $user_id id пользователя
     * @param int $select Что выбирать
     * @param int $page номер страницы
     * @return array
     */
    public function getList($user_id, $select, $page)
    {
        $cursor = $this->getCollection()->find(array_merge(array(
            'user_id' => (int)$user_id,
            'closed' => true,
        ), $this->getSelectCondition($select)))
            ->sort(array('updated' => -1))
            ->limit(self::PAGE_SIZE)
            ->skip($page * self::PAGE_SIZE);

        $list = array();
        for ($i = 0; $i < self::PAGE_SIZE; $i++) {
            if ($cursor->hasNext())
                $list [] = self::createModel($cursor->getNext());
        }

        return $list;
    }

    /**
     * Возвращает условие выбора уведомлений
     *
     * @param int $select что показываем
     * @return array
     */
    private function getSelectCondition($select)
    {
        switch ($select) {
            case self::SELECT_ACTIVITY:
                return array('type' => array('$nin' => array(self::TYPE_AWARD, self::TYPE_ACHIEVEMENT)));
            case self::SELECT_ACHIEVEMENTS:
                return array('type' => self::TYPE_ACHIEVEMENT);
            case self::SELECT_AWARDS:
                return array('type' => self::TYPE_AWARD);
        }

        return array();
    }

    /**
     * Создаение объекта из массива для удобной работы с ним
     * @param array $object
     * @return Notification|null
     */
    private static function createModel($object)
    {
        switch ($object['type']) {
            case self::TYPE_ACHIEVEMENT:
                $class = 'ScoreInputAchievement';
                break;
            case self::TYPE_AWARD:
                $class = 'ScoreInputAward';
                break;
            case self::TYPE_FIRST_BLOG_RECORD:
                $class = 'ScoreInputFirstBlogRecord';
                break;
            case self::TYPE_POST_ADDED:
                $class = 'ScoreInputNewPost';
                break;
            case self::TYPE_VIDEO:
                $class = 'ScoreInputNewVideo';
                break;
            case self::TYPE_FRIEND_ADDED:
                $class = 'ScoreInputNewFriend';
                break;
            case self::TYPE_COMMENT_ADDED:
                $class = 'ScoreInputNewComment';
                break;
            case self::TYPE_PHOTOS_ADDED:
                $class = 'ScoreInputNewPhoto';
                break;
            case self::TYPE_VISIT:
                $class = 'ScoreInputVisit';
                break;
            case self::TYPE_CONTEST_PARTICIPATION:
                $class = 'ScoreInputContestParticipation';
                break;
            case self::TYPE_CONTEST_WIN:
            case self::TYPE_CONTEST_2_PLACE:
            case self::TYPE_CONTEST_3_PLACE:
            case self::TYPE_CONTEST_4_PLACE:
            case self::TYPE_CONTEST_5_PLACE:
                $class = 'ScoreInputContestPrize';
        }
        if (!isset($class))
            return null;

        $model = new $class;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }

    /**
     * Отметить все сообщения как прочитанные
     */
    public function readAll($user_id)
    {
        $this->getCollection()->update(
            array(
                "user_id" => (int)$user_id,
                'read' => 0,
                'closed' => true
            ),
            array('$set' => array("read" => 1)),
            array('multiple' => true)
        );

        Yii::app()->db->createCommand()->update(
            UserScores::model()->tableName(),
            array('seen_scores' => new CDbExpression('scores')),
            'user_id=' . $user_id);
    }

    /**
     * Закрываем массовые уведомления
     */
    public function CheckClose()
    {
        do {
            $model = $this->getCollection()->findOne(array(
                'closed' => false,
                'created' => array('$lt' => (time() - 3 * 3600)),
            ));
            if (!empty($model))
                $this->close($model);
        } while (!empty($model));
    }

    /**
     * Закрыть уведомление
     * @param array $model
     */
    private function close($model)
    {
        $this->getCollection()->update(
            array('_id' => $model['_id']),
            array(
                '$set' => array('closed' => true, 'updated' => time())
            )
        );

        Yii::app()->db->createCommand()->update(UserScores::model()->tableName(),
            array('scores' => new CDbExpression('scores+ :scores', array(':scores' => $model['scores']))),
            'user_id=:user_id', array(':user_id' => $model['user_id'])
        );
    }

    /**
     * Возращает название уведомления
     * @return string
     */
    public function getTitle()
    {
        $action = ScoreAction::getActionInfo($this->type);
        return $action['title'];
    }

    public function descriptionClass()
    {
        return 'career-achievement__bluelight';
    }

    public function removeAll(){
        $this->getCollection()->remove(array());
    }
}