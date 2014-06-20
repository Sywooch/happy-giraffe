<?php

namespace site\frontend\modules\notifications\models;

/**
 * Description of DiscussSubscription
 *
 * @property \EMongoCriteria $dbCriteria Criteria
 * @author Кирилл
 */
class DiscussSubscription extends \EMongoDocument
{

    public $userId;
    public $entity;
    public $entityId;

    public function __construct($userId = false, $entity = false, $scenario = 'insert')
    {
        if ($userId)
            $this->userId = $userId;
        if ($entity)
        {
            $this->id = $entity->id;
            $this->class = get_class($entity);
        }
        parent::__construct($scenario);
    }

    /**
     * 
     * @param string $className
     * @return DiscussSubscription
     */
    public function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function indexes()
    {
        return array(
            'uid' => array(
                'key' => array(
                    'userId' => \EMongoCriteria::SORT_DESC,
                ),
            ),
            'eid' => array(
                'key' => array(
                    'entity' => \EMongoCriteria::SORT_ASC,
                    'entityId' => \EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }

    public function getCollectionName()
    {
        return 'discussSubscription';
    }

    /* scopes */

    /**
     * Фильтр по подпискам на определённую сущность
     * @param mixed $model Модель с int атрибутом id или массив array('entity' => class, 'entityId' => id)
     * @return \site\frontend\modules\notifications\models\DiscussSubscription
     */
    public function byModel($model)
    {
        if (is_object($model))
            $model = array('entity' => get_class($model), 'entityId' => (int) $model->id);
        $this->dbCriteria->addCond('entity', '==', $model['entity']);
        $this->dbCriteria->addCond('entityId', '==', $model['entityId']);

        return $this;
    }

    /**
     * 
     * @param int $userId
     * @return \site\frontend\modules\notifications\models\DiscussSubscription
     */
    public function byUser($userId)
    {
        $this->dbCriteria->addCond('userId', '==', (int) $userId);

        return $this;
    }

}

?>
