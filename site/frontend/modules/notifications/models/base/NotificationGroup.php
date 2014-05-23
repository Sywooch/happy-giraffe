<?php

/**
 * Class NotificationNewComment
 *
 * Уведомление пользователю о новом комментарии с возможностью группировки
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationGroup extends Notification
{

    /**
     * @var string Класс сущности
     */
    public $entity;

    /**
     * @var int id сущности
     */
    public $entity_id;

    /**
     * @var array массив id непрочитанных комментариев уведомления
     */
    public $unread_model_ids = array();

    /**
     * @var array массив id прочитанных комментариев уведомления
     */
    public $read_model_ids = array();

    /**
     * @var CommunityContent
     */
    protected $_entity = null;
    protected $_comments = null;

    /**
     * Создаем уведомление о новом комментарии. Если уведомление к этому посту уже создавалось и еще не было
     * прочитано, то добавляем в него новый комментарий и увеличиваем кол-во нотификаций
     *
     * @param $model_id int
     * @param array $params дополнительные параметры уведомления
     */
    protected function create($model_id, $params = array())
    {
        $this->ensureIndex();
        $exist = $this->getCollection()->findOne(array_merge(array(
            'type' => $this->type,
            'recipient_id' => (int) $this->recipient_id,
            'read' => 0,
            'entity' => $this->entity,
            'entity_id' => (int) $this->entity_id,
                ), $params));

        if ($exist)
        {
            //если такая модель уже есть в списке ничего не меняем
            if (in_array($model_id, $exist['unread_model_ids']))
                return;
            $this->update($exist, $model_id);
        }
        else
            $this->insert($model_id, $params);
    }

    /**
     * Добавление в существующее уведомление информации о новом комментарии/лайке к этой записи/фото
     *
     * @param $exist
     * @param $model_id int
     */
    public function update($exist, $model_id)
    {
        $this->getCollection()->update(
            array("_id" => $exist['_id']), array(
            '$set' => array("updated" => time()),
            '$inc' => array("count" => 1),
            '$push' => array("unread_model_ids" => (int) $model_id),
            )
        );

        $this->sendSignal();
    }

    /**
     * Создание нового уведомления о непрочитанном комментарии
     *
     * @param int|int[] $model_ids id модели связанной с уведомлением
     * @param $params дополнительные параметры уведомления
     */
    protected function insert($model_ids, $params = array())
    {
        if (!is_array($model_ids))
            $model_ids = array((int) $model_ids);

        parent::insert(array_merge(array(
            'entity' => $this->entity,
            'entity_id' => (int) $this->entity_id,
            'unread_model_ids' => $model_ids
                ), $params), count($model_ids));
    }

    /**
     * Помечаем комментарий как прочитанный
     * @param $model_id int
     */
    public function setCommentRead($model_id)
    {
        foreach ($this->unread_model_ids as $key => $unread_model_id)
            if ($unread_model_id == $model_id)
            {
                unset($this->unread_model_ids[$key]);
                $this->read_model_ids [] = (int) $model_id;
            }
    }

    /**
     * Сохраняем модель
     */
    public function save()
    {
        $this->count = count($this->unread_model_ids);

        if (empty($this->unread_model_ids))
            $this->read = 1;

        $this->getCollection()->update(
            array('_id' => $this->_id), array(
            '$set' => array(
                'unread_model_ids' => $this->unread_model_ids,
                'read_model_ids' => $this->read_model_ids,
                'count' => (int) $this->count,
                'read' => (int) $this->read,
            )
            )
        );
    }

    /**
     * Удалить упоминание об удаленном комментарии в уведомлении.
     * Если в уведомлении только один этот комментарий, удалить всё уведомление
     *
     * @param $exist array
     * @param $attribute string в прочитанных или непрочитанных
     * @param $comment_id int id комментария
     */
    protected function removeCommentId($exist, $attribute, $comment_id)
    {
        unset($exist[$attribute][array_search($comment_id, $exist[$attribute])]);

        //если уведомление стало пустым, удаляем
        if (empty($exist['read_model_ids']) && empty($exist['unread_model_ids']))
        {
            $this->deleteByPk($exist['_id']);
        }
        else
        {
            //иначе обновляем его
            $this->getCollection()->update(
                array('_id' => $exist['_id']), array('$set' => array(
                    'read_model_ids' => $exist['read_model_ids'],
                    'unread_model_ids' => $exist['unread_model_ids'],
                    'count' => ($exist['count'] - 1),
                ))
            );
        }

        if ($attribute == 'unread_model_ids')
            $this->sendSignal(-1);
    }

    /**
     * Возвращает урл для редиректа пользователя
     * @return string
     */
    public function getUrl()
    {
        if (!empty($this->unread_model_ids))
            $comment_id = min($this->unread_model_ids);
        elseif (!empty($this->read_model_ids))
            $comment_id = min($this->read_model_ids);

        if (!isset($comment_id))
            return '';

        $comment = Comment::model()->findByPk($comment_id);
        if ($comment === null)
            return '';
        return $comment->getUrl();
    }

    /**
     * Отображаемое количество уведомлений
     * @return int
     */
    public function getVisibleCount()
    {
        if ($this->read == 0)
            return count($this->unread_model_ids);
        else
            return count($this->unread_model_ids) + count($this->read_model_ids);
    }

    /**
     * Возвращает модель
     *
     * @return CActiveRecord|CommunityContent|null
     */
    public function getEntity()
    {
        if ($this->_entity === null)
        {
            if ($this->entity == 'CommunityContent' || $this->entity == 'BlogContent')
                $this->_entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
            else
                $this->_entity = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        }

        return $this->_entity;
    }

    /**
     * @return int
     */
    public function getText()
    {
        return Str::GenerateNoun(array('Новый комментарий', 'Новых комментария', 'Новых комментариев'), $this->count);
    }

    public function getComments()
    {
        if (is_null($this->_comments))
        {
            $this->_comments = Comment::model()->with('author')->findAllByPk($this->unread_model_ids);
        }
        
        return $this->_comments;
    }

}