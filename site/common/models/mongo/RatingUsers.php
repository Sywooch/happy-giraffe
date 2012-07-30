<?php
/**
 * User: Eugene
 * Date: 02.03.12
 */
class RatingUsers extends EMongoDocument
{
    public $uid;
    public $key;
    public $entity = array();


    public function getCollectionName()
    {
        return 'rating_users';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('uid, key, entity', 'safe'),
        );
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->isNewRecord){
            //Yii::import('site.frontend.modules.scores.models.*');
            //UserScores::addScores($this->user_id, ScoreAction::ACTION_LIKE);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        //Yii::import('site.frontend.modules.scores.models.*');
        //UserScores::removeScores($this->user_id, ScoreAction::ACTION_LIKE);
    }

    public function findByUser($uid, $key)
    {
        $model = RatingUsers::model()->findByAttributes(array(
            'uid' => $uid,
            'key' => $key
        ));
        if(!$model)
        {
            $model = new RatingUsers;
            $model->uid = $uid;
            $model->key = $key;
            $model->save();
        }
        return $model;
    }

    public function checkByUser($uid, $key, $entity, $entity_id)
    {
        $model = $this->findByUser($uid, $key);
        if(array_key_exists($entity . '_' . $entity_id, $model->entity))
            return true;
        return false;
    }

    public function saveByUser($uid, $key, $entity, $entity_id)
    {
        $model = $this->findByUser($uid, $key);
        if(!$this->checkByUser($uid, $key, $entity, $entity_id))
        {
            $model->entity[$entity . '_' . $entity_id] = true;
            return $model->save();
        }
        else
            return false;
    }
}
