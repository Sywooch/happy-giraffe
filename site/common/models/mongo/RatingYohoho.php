<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eugene
 * Date: 20.02.12
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */
class RatingYohoho extends HMongoModel
{
    public $entity_id;
    public $entity_name;
    public $user_id;

    public function getCollectionName()
    {
        return 'ratings_yohoho';
    }

    /**
     * @param string $className
     * @return RatingYohoho
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('entity_id, entity_name, user_id', 'safe'),
        );
    }

    /**
     * @param $entity
     * @return RatingYohoho
     */
    public function findByEntity($entity)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $criteria = new EMongoCriteria;
        $criteria->entity_id('==', $entity_id);
        $criteria->entity_name('==', $entity_name);
        $criteria->user_id('==', (int)Yii::app()->user->id);

        return $this->find($criteria);
    }

    /**
     * @param $entity
     * @return bool
     */
    public function saveByEntity($entity)
    {
        $model = $this->findByEntity($entity);
        if ($model)
            $model->delete();
        else
        {
            $model = new $this;
            $model->entity_id = (int)$entity->primaryKey;
            $model->entity_name = get_class($entity);
            $model->user_id = (int)Yii::app()->user->id;
            $model->save();
            return true;
        }
        return false;
    }

    /**
     * @param $entity
     * @return RatingYohoho
     */
    public function create($entity){
        $model = new $this;
        $model->entity_id = (int)$entity->primaryKey;
        $model->entity_name = get_class($entity);
        $model->user_id = (int)Yii::app()->user->id;
        $model->save();
        return $model;
    }
}
