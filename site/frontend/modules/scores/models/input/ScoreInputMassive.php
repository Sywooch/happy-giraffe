<?php
/**
 * Class ScoreInput
 *
 * Модель начисления баллов пользователю с привязкой к како-либо модели
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
abstract class ScoreInputMassive extends ScoreInput
{
    /**
     * @var array
     */
    public $ids = array();

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $id int id модели
     * @param $wait_time
     */
    public function add($user_id, $id, $wait_time)
    {
        $this->user_id = $user_id;
        $model = $this->getCollection()->findOne(array(
            'type' => (int)$this->type,
            'user_id' => (int)$this->user_id,
            'show_time' => array('$gt' => time())
        ));

        if (empty($model))
            $this->insert(array('ids' => array((int)$id)), time() + $wait_time);
        else {
            $this->getCollection()->update(array('_id' => $model['_id']), array(
                '$push' => array('ids' => (int)$id),
                '$inc' => array('scores' => $this->getScores())
            ));
            $this->addScores();
        }
    }

    /**
     * Вычитание баллов
     *
     * @param $id int id модели
     */
    public function remove($id)
    {
        $model = $this->find($id);
        if ($model) {
            $this->getCollection()->update(array('_id' => $model['_id']), array(
                '$pull' => array('ids' => (int)$id),
                '$inc' => array('scores' => -$this->getScores())
            ));
            $this->removeScores();
        }
    }

    /**
     * Найти уведомление содержащее id
     *
     * @param $id int
     * @return array|null
     */
    protected function find($id)
    {
        return $this->getCollection()->findOne(array(
            'type' => (int)$this->type,
            'user_id' => (int)$this->user_id,
            'ids' => (int)$id,
        ));
    }
}