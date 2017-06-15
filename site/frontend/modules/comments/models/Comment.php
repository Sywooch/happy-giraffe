<?php

namespace site\frontend\modules\comments\models;
use site\frontend\modules\posts\models\Content;

/**
 * @property string $id
 * @property string $text
 * @property string $created
 * @property string $author_id
 * @property string $entity
 * @property string $entity_id
 * @property string $response_id
 * @property string $root_id
 * @property string $removed
 * @property int $new_entity_id
 * @property array $answers Обсуждение под данным комментарием
 *
 * @property Content $post
 */
class Comment extends \Comment implements \IHToJSON
{

    protected static $_commentEntityList = array();
    protected $_rootType = false;
    protected $_subComments = null;
    
    protected $oldEntityList = array(
        'CommunityContent',
        'BlogContent',
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function toJSON()
    {
        $json = array(
            'id' => (int) $this->id,
            'entity' => $this->entity,
            'entityId' => (int) $this->entity_id,
            'authorId' => (int) $this->author_id,
            'purifiedHtml' => $this->purified->text,
            'originHtml' => $this->forEdit->text,
            'specialistLabel' => $this->getSpecialistLabel(),
            'likesCount' => $this->getLikesCount(),
            'photoId' => (int) $this->getPhotoId(),
            'entityUrl' => $this->getUrl(true),
            'responseId' => (int) $this->response_id,
            'rootId' => (int) $this->root_id,
            'dtimeCreate' => (int) strtotime($this->created),
        );

        if (!is_null($this->answers)) {
            $json['answers'] = array();
            foreach ($this->answers as $answer)
                $json['answers'][] = $answer->toJSON();
        }

        return $json;
    }

    public function getPhotoId()
    {
        return $this->entity == 'AlbumPhoto' ? $this->entity_id : false;
    }

    public function getSpecialistLabel()
    {
        return ($this->entity == 'CommunityContent' && $this->commentEntity !== null && $this->commentEntity->type_id == \CommunityContentType::TYPE_QUESTION && ($specialist = $this->author->getSpecialist($this->commentEntity->rubric->community_id)) !== null) ? mb_strtolower($specialist->title, 'UTF-8') : null;
    }

    public function getLikesCount()
    {
        return \HGLike::model()->countByEntity($this);
    }

    /**
     * @return CommunityContent
     */
    public function getCommentEntity()
    {
        if (!isset(self::$_commentEntityList[$this->entity]) || !isset(self::$_commentEntityList[$this->entity][$this->entity_id]))
            self::$_commentEntityList[$this->entity][$this->entity_id] = parent::getCommentEntity();

        return self::$_commentEntityList[$this->entity][$this->entity_id];
    }

    public function getUrl($absolute = false)
    {
        // Если не уверены, что есть метод getUrl
        if (!in_array($this->entity, array('CommunityContent', 'BlogContent', 'CookRecipe', 'User', 'AlbumPhoto', 'Route', 'Service', 'AdvPost')))
            return false;
        // Потерялась сущность
        if ($this->commentEntity === null)
            return '';
        if (Content::$entityAliases[$this->entity] == 'site\frontend\modules\posts\models\Content') {
            $url = $this->commentEntity->url;
        } else {
            // Для getUrl($comments = false, $absolute = false)
            if (!in_array($this->entity, array('CommunityContent', 'BlogContent', 'CookRecipe', 'User', 'AlbumPhoto')))
                $url = $this->commentEntity->getUrl(false, $absolute);
            // Для getUrl($absolute = false)
            if (!in_array($this->entity, array('User', 'Route')))
                $url = $this->commentEntity->getUrl($absolute);
            // Для getUrl($comments = false)
            if (!in_array($this->entity, array('Service'))) {
                $url = $this->commentEntity->getUrl(false);
                if ($absolute)
                    $url = \Yii::app()->createAbsoluteUrl($url);
            }
        }

        // Добавляем хеш для комментария
        return $url . '#comment_' . $this->id;
    }

    public function getAnswers()
    {
        return $this->_subComments;
    }

    /**
     * Переобъявляем, что бы можно было достать вложенные комментарии при использовании условия rootLimit
     * 
     * @param type $data
     * @param type $callAfterFind
     * @param type $index
     * @return type
     */
    public function populateRecords($data, $callAfterFind = true, $index = null)
    {
        // Получаем список моделей корневых элементов
        $models = parent::populateRecords($data, $callAfterFind, $index);
        // Если было применено условие, накладывающее ограницение на количество корневых комментариев
        if ($this->_rootType) {
            // Сделаем дополнительный запрос за вложенными комментариями
            $type = $this->_rootType;
            $this->_rootType = false;
            $ids = \CHtml::listData($models, 'id', 'id');
            $subComments = $this->rootLimitSupporting(array_values($ids))->findAll();
            if (count($ids) !== 0 && count($subComments) !== 0) {
                $map = array_combine(array_keys($ids), range(0, count($ids) - 1));
                if ($type == 'list') {
                    $offset = 0;
                    // Добавим вложенные комментарии в ответ
                    foreach ($subComments as $comment) {
                        $offset++;
                        array_splice($models, $map[$comment->root_id] + $offset, 0, array($comment));
                    }
                } elseif ($type == 'tree') {
                    foreach ($models as $i => $model)
                        $models[$i]->_subComments = array();
                    foreach ($subComments as $comment)
                        $models[$map[$comment->root_id]]->_subComments[] = $comment;
                }
            }
        }

        return $models;
    }
    
/**    protected function instantiate($attributes)
    {
        return in_array($this->entity, $this->oldEntityList) ? new Comment(null) : new \site\frontend\modules\comments\models\ClearComment(null);
    }*/

    public static function getCacheDependency($entity)
    {
        if (!is_array($entity)) {
            $entity = array(
                'entity' => get_class($entity),
                'entity_id' => $entity->id,
            );
        } elseif (!isset($entity['entity_id'])) {
            $entity['entity_id'] = $entity['entityId'];
        }
        $dependency = new \CDbCacheDependency("SELECT COUNT(id) FROM " . Comment::model()->tableName() . " WHERE entity = :entity AND entity_id = :entity_id");
        $dependency->params = array(
            ':entity' => $entity['entity'],
            ':entity_id' => $entity['entity_id'],
        );
        return $dependency;
    }

    /* scopes */

    public function byEntity($entity)
    {
        /** @todo Проверить правильность $entity */
        if (!is_array($entity)) {
            $entity = array(
                'entity' => get_class($entity),
                'entity_id' => $entity->id,
            );
        }
        $this->dbCriteria->addColumnCondition($entity);

        return $this;
    }

    public function dtimeFrom($dtime)
    {
        $this->dbCriteria->compare('created', '<' . date('Y-m-d H:i', $dtime));

        return $this;
    }

    /**
     * Условие работает хитро, и в populateRecords инициирует второй запрос для вытаскивания вложенных комментариев
     * 
     * @param int $limit
     * @param string $type list/tree
     * @return \site\frontend\modules\comments\models\Comment
     */
    public function rootLimit($limit, $type = 'list')
    {
        $this->_rootType = $type;
        $this->dbCriteria->addCondition('id = root_id');
        $this->dbCriteria->limit = $limit;

        return $this;
    }

    /**
     * Вспомогательное условие, не рекомендуется вызывать напрямую
     * 
     * @param array $ids
     * @return \site\frontend\modules\comments\models\Comment
     */
    public function rootLimitSupporting($ids)
    {
        $this->dbCriteria->addInCondition('root_id', $ids);
        $this->dbCriteria->addCondition('id <> root_id');
        $this->dbCriteria->order = $this->tableAlias . '.`root_id` DESC, ' . $this->tableAlias . '.`created` ASC';

        return $this;
    }

    public static function getChannel($model)
    {
        if ($model instanceof Comment) {
            $model = array(
                'entity' => $model->entity,
                'entityId' => $model->entity_id,
            );
        } elseif (is_object($model)) {
            $model = array(
                'entity' => get_class($model),
                'entityId' => $model->id,
            );
        }

        return $model['entity'] . '_' . $model['entityId'];
    }

    /**
     * @param int $id
     *
     * @return Comment
     */
    public function byNewEntity($id)
    {
        $this->getDbCriteria()->compare('new_entity_id', $id);

        return $this;
    }
}

?>
