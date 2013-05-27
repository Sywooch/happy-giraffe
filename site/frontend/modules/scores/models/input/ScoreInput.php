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
    const TYPE_6_STEPS = 1;

    const TYPE_FIRST_BLOG_RECORD = 2;
    const TYPE_POST_ADDED = 3;
    const TYPE_VIDEO = 4;

    const TYPE_FRIEND_ADDED = 5;

    const TYPE_COMMENT_ADDED = 7;
    const TYPE_PHOTOS_ADDED = 8;

    const TYPE_DUEL_PARTICIPATION = 9;
    const TYPE_DUEL_WIN = 10;

    const TYPE_VISIT = 11;

    const TYPE_CONTEST_PARTICIPATION = 20;
    const TYPE_CONTEST_WIN = 21;
    const TYPE_CONTEST_2_PLACE = 22;
    const TYPE_CONTEST_3_PLACE = 23;
    const TYPE_CONTEST_4_PLACE = 24;
    const TYPE_CONTEST_5_PLACE = 25;
    const TYPE_CONTEST_ADDITIONAL_PRIZE = 26;

    const TYPE_AWARD = 100;
    const TYPE_ACHIEVEMENT = 101;

    const TYPE_RATING_BLOGS = 105;
    const TYPE_RATING_INTERESTING = 106;

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
     * @var bool прочитано ли сообщение о начислении баллов
     */
    public $read;
    /**
     * @var int время когда сообщение о начислении баллов начинается отображается у пользователя
     * нужно для группировки баллов
     */
    public $show_time;

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
    protected function ensureIndex()
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
     * @param int|null $show_time время когда сообщение о начислении баллов начинается отображается у пользователя
     */
    protected function insert($specific_fields = array(), $show_time = null)
    {
        if (empty($show_time))
            $show_time = time();

        $this->getCollection()->insert(
            array_merge(array(
                'type' => (int)$this->type,
                'user_id' => (int)$this->user_id,
                'scores' => (int)$this->getScores(),
                'updated' => time(),
                'read' => 0,
                'show_time' => $show_time,
            ), $specific_fields)
        );

        $this->sendSignal($this->scores);
    }

    /**
     * Возвращае количество баллов за действия
     *
     * @return int
     */
    protected function getScores()
    {
        return ScoreAction::getActionScores($this->type);
    }
}