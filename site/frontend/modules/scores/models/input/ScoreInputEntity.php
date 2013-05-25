<?php
/**
 * Class ScoreInput
 *
 * Модель начисления баллов пользователю с привязкой к како-либо модели
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ScoreInputEntity extends ScoreInput
{
    public $entity;
    public $entity_id;

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function add($user_id, $entity)
    {
        $this->user_id = $user_id;
        $this->insert(array(
            'entity' => get_class($entity),
            'entity_id' => $entity->id,
        ));
    }
}