<?php
/**
 * Class ScoreInput
 *
 * Модель начисления баллов пользователю с привязкой к како-либо модели
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
abstract class ScoreInputEntity extends ScoreInput
{
    public $entity;
    public $entity_id;
    public $ids;

    /**
     * Добавление баллов
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function add($user_id, $entity)
    {
        $this->user_id = $user_id;
        parent::insert(array(
            'entity' => get_class($entity),
            'entity_id' => (int)$entity->id,
        ));
    }

    /**
     * Вычитание баллов
     *
     * @param $user_id int id пользователя
     * @param $entity CActiveRecord модель
     */
    public function remove($user_id, $entity){
        $this->user_id = $user_id;
        parent::remove(array(
            'entity' => get_class($entity),
            'entity_id' => (int)$entity->id,
        ));
    }

    public function getLink()
    {
        $model = CActiveRecord::model($this->entity)->model()->findByPk($this->entity_id);
        if ($model && isset($model->title))
            return CHtml::link(Str::truncate($model->title, 90), $model->getUrl(), array('class' => 'career-achievement_a'));

        return '';
    }
}