<?php

namespace site\frontend\modules\notifications\models;

/**
 * Description of Notification
 *
 * @author Кирилл
 * 
 * @property Entity $entity Сущность, к которой привязаны события
 * @property \EMongoCriteria $dbCriteria
 */
class Notification extends \EMongoDocument
{
    /**
     * Новый комментарий
     */

    const TYPE_USER_CONTENT_COMMENT = 0;

    /**
     * Ответ на комментарий
     */
    const TYPE_REPLY_COMMENT = 1;

    /**
     * Продолжение дискуссии
     */
    const TYPE_DISCUSS_CONTINUE = 2;

    /**
     * Новый лайк
     */
    const TYPE_NEW_LIKE = 5;

    /**
     * Новое добавление в избранное
     */
    const TYPE_NEW_FAVOURITE = 6;

    /**
     *
     * @var int Тип оповещения (см константы TYPE_*)
     */
    public $type;

    /**
     *
     * @var int Id пользователя, для которого уведомление
     */
    public $userId;

    /**
     *
     * @var int Дата обновления
     */
    public $dtimeUpdate;

    /**
     *
     * @var int Количество непрочитанных уведомлений, обновляется автоматически
     */
    public $unreadCount = 0;

    /**
     *
     * @var int Количество прочитанных уведомлений, обновляется автоматически
     */
    public $readCount = 0;

    /**
     * @var Entity[] Непрочитанные оповещения
     */
    public $unreadEntities;

    /**
     * @var Entity[] Прочитанные оповещения
     */
    public $readEntities;

    public function indexes()
    {
        return array(
            'uid' => array(
                'key' => array(
                    'userId' => \EMongoCriteria::SORT_ASC,
                ),
            ),
            'date' => array(
                'key' => array(
                    'dtimeUpdate' => \EMongoCriteria::SORT_DESC,
                ),
            ),
        );
    }

    public function embeddedDocuments()
    {
        return array(
            'entity' => 'site\frontend\modules\notifications\models\Entity',
        );
    }

    public function behaviors()
    {
        return array(
            'embededUnreadEntities' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'unreadEntities',
                'arrayDocClassName' => 'site\frontend\modules\notifications\models\Entity'
            ),
            'embededReadEntities' => array(
                'class' => 'ext.YiiMongoDbSuite.extra.EEmbeddedArraysBehavior',
                'arrayPropertyName' => 'readEntities',
                'arrayDocClassName' => 'site\frontend\modules\notifications\models\Entity'
            ),
        );
    }

    /**
     * 
     * @param string $className
     * @return Notification
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'signals';
    }

    /**
     * 
     * @return int Сумма всех непрочитанных уведомлений текущего пользователя
     */
    public static function getUnreadSum()
    {
        $res = self::model()->getCollection()->aggregate(
            array(
                array(
                    '$match' => array('userId' => (int) \Yii::app()->user->id),
                ),
                array(
                    '$group' => array('_id' => '$userId', 'count' => array('$sum' => '$unreadCount'))
                )
            )
        );
        $res = $res['result'];

        return isset($res[0]) && isset($res[0]['count']) ? $res[0]['count'] : 0;
    }

    /**
     * 
     * @return int Количество непрочитанных уведомлений текущего пользователя
     */
    public static function getUnreadCount()
    {
        return self::model()->unread()->byUser(\Yii::app()->user->id)->count();
    }

    public function beforeSave()
    {
        $unreadCount = count($this->unreadEntities);
        if (is_null($this->dtimeUpdate) || $this->unreadCount > $unreadCount)
            $this->updateTime();
        $this->unreadCount = $unreadCount;
        $this->readCount = count($this->readEntities);

        return parent::beforeSave();
    }

    public function updateTime()
    {
        $this->dtimeUpdate = time();
    }

    public function read($entity)
    {
        if (is_object($entity))
            $entity = array(
                'id' => $entity->id,
                'class' => get_class($entity),
            );
        foreach ($this->unreadEntities as $k => $e)
            if ($e->id == $entity['id'])
            {
                $this->readEntities[] = $e;
                unset($this->unreadEntities[$k]);
                return;
            }
    }

    public function readAll()
    {
        $this->readEntities = \CMap::mergeArray($this->readEntities, $this->unreadEntities);
        $this->unreadEntities = array();
    }

    public static function markAllSignalsAsRead($userId)
    {
        $models = self::model()->unread()->byUser($userId)->findAll();
        foreach ($models as $model)
        {
            $model->readAll();
            $model->save();
        }
    }

    /* scopes */

    /**
     * 
     * @return \site\frontend\modules\notifications\models\Notification
     */
    public function unread()
    {
        $this->dbCriteria->addCond('unreadCount', '>', 0);

        return $this;
    }

    /**
     * Фильтр по событиям на определённую сущность
     * @param mixed $entity Модель с int атрибутом id или массив array('entity' => class, 'entityId' => id)
     * @return \site\frontend\modules\notifications\models\DiscussSubscription
     */
    public function byEntity($entity)
    {
        if (is_object($entity))
            $entity = array('entity' => get_class($entity), 'entityId' => (int) $entity->id);

        $this->dbCriteria->addCond('entity.class', '==', $entity['entity']);
        $this->dbCriteria->addCond('entity.id', '==', $entity['entityId']);

        return $this;
    }

    /**
     * 
     * @param int $type
     * @return \site\frontend\modules\notifications\models\Notification
     */
    public function byType($type)
    {
        $this->dbCriteria->addCond('type', '==', (int) $type);

        return $this;
    }

    /**
     * 
     * @param int $userId
     * @return \site\frontend\modules\notifications\models\Notification
     */
    public function byUser($userId)
    {
        $this->dbCriteria->addCond('userId', '==', (int) $userId);

        return $this;
    }

    /**
     * Добавляет условие, находящее сигналы, в которых есть упоминание об указанной сущности
     * Не рекомендуется использовать без дополнительных ограницений
     * 
     * @param mixed $entity Модель с int атрибутом id или массив array('entity' => class, 'entityId' => id)
     * @return \site\frontend\modules\notifications\models\Notification
     */
    public function byInitiatingEntity($entity)
    {
        if (is_object($entity))
            $entity = array('entity' => get_class($entity), 'entityId' => (int) $entity->id);
        
        $conds = $this->dbCriteria->getConditions();
        
        $conds['$where'] = new \MongoCode('
            function() {
                if(this.unreadEntities)
                for(var i = 0; i < this.unreadEntities.length; i++) {
                    if(this.unreadEntities[i].id == entityId && this.unreadEntities[i].class == entity)
                        return true;
                }
                if(this.readEntities)
                for(var i = 0; i < this.readEntities.length; i++) {
                    if(this.readEntities[i].id == entityId && this.readEntities[i].class == entity)
                        return true;
                }
            }', $entity);
        
        $this->dbCriteria->setConditions($conds);
        
        return $this;
    }
}

?>
