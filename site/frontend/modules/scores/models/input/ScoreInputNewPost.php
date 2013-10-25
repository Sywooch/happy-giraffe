<?php
/**
 * Class ScoreInputNewPost
 *
 * Начисление баллов пользователю за запись
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputNewPost extends ScoreInputEntity
{
    public $type = self::TYPE_POST_ADDED;

    /**
     * @var ScoreInputNewPost
     */
    private static $_instance;

    /**
     * @return ScoreInputNewPost
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
            self::$_instance = new self();

        return self::$_instance;
    }

    public function __construct()
    {
    }

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function add($user_id, $entity)
    {
        parent::add($user_id, $entity);
    }

    /**
     * Вычитание баллов
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function remove($user_id, $entity)
    {
        parent::remove($user_id, $entity);
    }

    /**
     * Возвращает класс для иконки
     * @return string
     */
    public function getIcon()
    {
        return 'career-achievement-ico__blog';
    }

    /**
     * Массовое добавление прошлой активности
     * @param int $user_id
     * @param int[] $ids
     */
    public function addMassive($user_id, $ids)
    {
        $this->user_id = (int)$user_id;
        $this->scores = ScoreAction::getActionScores($this->type) * count($ids);
        $this->getCollection()->insert(array(
            'type' => $this->type,
            'user_id' => (int)$this->user_id,
            'scores' => (int)$this->scores,
            'updated' => time(),
            'read' => 0,
            'created' => time(),
            'closed' => true,
            'ids' => $ids
        ));
        $this->addScores();
    }

    /**
     * Возращает название уведомления
     * @return string
     */
    public function getTitle()
    {
        if (empty($this->ids))
            return 'За новую запись';
        else
            return 'За новые записи';
    }
}