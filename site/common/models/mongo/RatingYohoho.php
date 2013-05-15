<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eugene
 * Date: 20.02.12
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */
class RatingYohoho extends EMongoDocument
{
    public $entity_id;
    public $entity_name;
    public $user_id;

    public function getCollectionName()
    {
        return 'ratings_yohoho';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function indexes()
    {
        return array(
            'entity' => array(
                'key' => array(
                    'entity_id' => -1,
                    'entity_name' => 1,
                )
            ),
            'user_entity' => array(
                'key' => array(
                    'entity_id' => -1,
                    'entity_name' => 1,
                    'user_id' => 1,
                )
            )
        );
    }

    public function rules()
    {
        return array(
            array('entity_id, entity_name, user_id', 'safe'),
        );
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord) {
            //добавляем баллы
//            Yii::import('site.frontend.modules.scores.models.*');
//            UserScores::addScores($this->user_id, ScoreAction::ACTION_YOHOHO_LIKE, 1, array(
//                'id' => $this->entity_id, 'name' => $this->entity_name));
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        //вычитаем баллы
//        Yii::import('site.frontend.modules.scores.models.*');
//        UserScores::removeScores($this->user_id, ScoreAction::ACTION_YOHOHO_LIKE, 1, array(
//            'id' => $this->entity_id, 'name' => $this->entity_name));
    }

    public function findByEntity($entity)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $criteria = new EMongoCriteria;
        $criteria->entity_id('==', $entity_id);
        $criteria->entity_name('==', $entity_name);
        $criteria->user_id('==', (int)Yii::app()->user->id);

        $model = $this->find($criteria);
        if ($model)
            return $model;
        return false;
    }

    public function saveByEntity($entity)
    {
        $model = $this->findByEntity($entity);
        if ($model)
            $model->delete();
        else {
            $model = new $this;
            $model->entity_id = (int)$entity->primaryKey;
            $model->entity_name = get_class($entity);
            $model->user_id = (int)Yii::app()->user->id;
            $model->save();
            return true;
        }
        return false;
    }
}
