<?php

namespace site\frontend\modules\comments\models;

/**
 * Description of Comment
 *
 * @author Кирилл
 * @property array $answers Обсуждение под данным комментарием
 */
class Comment extends \Comment
{

    protected static $_commentEntityList = array();
    protected $_rootType = false;
    protected $_subComments = null;

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

        if (!is_null($this->answers))
        {
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
        return ($this->entity == 'CommunityContent' && $this->commentEntity->type_id == \CommunityContentType::TYPE_QUESTION && ($specialist = $this->author->getSpecialist($this->commentEntity->rubric->community_id)) !== null) ? mb_strtolower($specialist->title, 'UTF-8') : null;
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
            self::$_commentEntityList[$this->entity][$this->entity_id] = \CActiveRecord::model($this->entity)->findByPk($this->entity_id);

        return self::$_commentEntityList[$this->entity][$this->entity_id];
    }

    public function getUrl($absolute = false)
    {
        // Если не уверены, что есть метод getUrl
        if (!in_array($this->entity, array('CommunityContent', 'BlogContent', 'CookRecipe', 'User', 'AlbumPhoto', 'Route', 'Service')))
            return false;
        // Потерялась сущность
        if ($this->commentEntity === null)
            return '';
        // Для getUrl($comments = false, $absolute = false)
        if (!in_array($this->entity, array('CommunityContent', 'BlogContent', 'CookRecipe', 'User', 'AlbumPhoto')))
            $url = $this->commentEntity->getUrl(false, $absolute);
        // Для getUrl($absolute = false)
        if (!in_array($this->entity, array('User', 'Route')))
            $url = $this->commentEntity->getUrl($absolute);
        // Для getUrl($comments = false)
        if (!in_array($this->entity, array('Service')))
        {
            $url = $this->commentEntity->getUrl(false);
            if ($absolute)
                $url = \Yii::app()->createAbsoluteUrl($url);
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
        if ($this->_rootType)
        {
            // Сделаем дополнительный запрос за вложенными комментариями
            $type = $this->_rootType;
            $this->_rootType = false;
            $ids = \CHtml::listData($models, 'id', 'id');
            $subComments = $this->rootLimitSupporting(array_values($ids))->findAll();
            if (count($ids) !== 0 && count($subComments) !== 0)
            {
                $map = array_combine(array_keys($ids), range(0, count($ids) - 1));
                if ($type == 'list')
                {
                    $offset = 0;
                    // Добавим вложенные комментарии в ответ
                    foreach ($subComments as $comment)
                    {
                        $offset++;
                        array_splice($models, $map[$comment->root_id] + $offset, 0, array($comment));
                    }
                }
                elseif ($type == 'tree')
                {
                    foreach ($models as $i => $model)
                        $models[$i]->_subComments = array();
                    foreach ($subComments as $comment)
                        $models[$map[$comment->root_id]]->_subComments[] = $comment;
                }
            }
        }

        return $models;
    }

    /* scopes */

    public function byEntity($entity)
    {
        /** @todo Проверить правильность $entity */
        if (!is_array($entity))
        {
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

}

?>
