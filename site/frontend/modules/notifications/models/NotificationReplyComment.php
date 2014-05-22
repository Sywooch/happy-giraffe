<?php
/**
 * Class NotificationReplyComment
 *
 * Уведомление пользователю об ответе на его комментарий
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationReplyComment extends NotificationGroup
{
    /**
     * @var NotificationReplyComment
     */
    private static $_instance;
    public $type = self::REPLY_COMMENT;
    /**
     * @var int id комментария пользователя на который он получает ответы
     */
    public $comment_id;
    protected $_comment = null;

    public function __construct()
    {
    }

    /**
     * @return NotificationReplyComment
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Создаем уведомление об ответе на его комментарий. Если уведомление к этому комментарию уже создавалось
     * и еще не было прочитано, то добавляем в него новый комментарий и увеличиваем кол-во нотификаций
     *
     * @param $comment Comment комментарий
     * @param $response Comment комментарий на который ответили
     */
    public function create($comment, $response)
    {
        $this->recipient_id = (int)$response->author_id;
        $this->entity = $comment->entity;
        $this->entity_id = (int)$comment->entity_id;

        parent::create($comment->id, array('comment_id' => (int)$response->id));
    }

    /**
     * Найти удалить или изменить уведомление, связанное с удаленным комментарием
     * 1. Если удалили комментарий, на который поступали ответы, удаляем такие
     * уведомления полностью
     * 2. Если удалили комментарий-ответ, меняем такое уведомление
     *
     * @param $comment Comment
     */
    public function fixCommentNotification($comment)
    {
        //Если удалили комментарий, на который поступали ответы, удаляем такие уведомления полностью
        $this->getCollection()->remove(array(
            'type' => $this->type,
            'comment_id' => $comment->id,
        ));

        //Если удалили комментарий-ответ, меняем такое уведомление
        $query = array(
            'type' => $this->type,
            'entity' => $comment->entity,
            'entity_id' => (int)$comment->entity_id,
        );

        if (!empty($comment->response_id))
            $cursor = $this->getCollection()->find(array_merge($query, array('comment_id' => (int)$comment->response_id)));
        elseif (!empty($comment->quote_id))
            $cursor = $this->getCollection()->find(array_merge($query, array('comment_id' => (int)$comment->quote_id))); else return;

        while ($cursor->hasNext()) {
            $exist = $cursor->getNext();
            if (!isset($exist['read_model_ids']))
                $exist['read_model_ids'] = array();

            if (in_array($comment->id, $exist['read_model_ids']))
                $this->removeCommentId($exist, 'read_model_ids', $comment->id);
            elseif (in_array($comment->id, $exist['unread_model_ids']))
                $this->removeCommentId($exist, 'unread_model_ids', $comment->id);
        }
    }
    
    public function getComment()
    {
        if(is_null($this->_comment))
            $this->_comment = Comment::model()->findByPk($this->comment_id);
        return $this->_comment;
    }
}