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
     * @param $id int id модели
     */
    public function add($id)
    {
        $model = $this->getCollection()->findOne(array(
            'type' => (int)$this->type,
            'user_id' => (int)$this->user_id,
            'closed' => false
        ));

        if (empty($model))
            $this->insert(array('ids' => array((int)$id)), false);
        else {
            $this->getCollection()->update(array('_id' => $model['_id']), array(
                '$push' => array('ids' => (int)$id),
                '$inc' => array('scores' => $this->getScores())
            ));
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

    /**
     * Массовое добавление прошлой активности
     * @param int $user_id
     * @param int[] $ids
     */
    public function addMassive($user_id, $ids)
    {
        $this->user_id = (int)$user_id;
        $this->scores = ScoreAction::getActionScores($this->type)*count($ids);
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
}