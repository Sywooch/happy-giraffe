<?php
/**
 * Class NotificationUserContentComment
 *
 * Уведомление пользователю о новом комментарии
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationUserContentComment extends NotificationGroup
{
    /**
     * @var Notification
     */
    private static $_instance;
    public $type = self::USER_CONTENT_COMMENT;

    public function __construct()
    {
    }

    /**
     * @return NotificationUserContentComment
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Создаем уведомление о новом комментарии. Если уведомление к этому посту уже создавалось и еще не было
     * прочитано, то добавляем в него новый комментарий и увеличиваем кол-во нотификаций
     *
     * @param $recipient_id int id пользователя, который должен получить уведомление
     * @param $comment Comment комментарий
     */
    public function create($recipient_id, $comment)
    {
        $this->recipient_id = (int)$recipient_id;
        $this->entity = $comment->entity;
        $this->entity_id = (int)$comment->entity_id;

        parent::create($comment->id);
    }

    /**
     * Создает модель уведомления для удобой работы с ним
     *
     * @param $object array объект, который вернул компонент работы с базой
     * @return NotificationUserContentComment
     */
    public static function createModel($object)
    {
        $model = new NotificationUserContentComment;
        foreach ($object as $key => $value)
            $model->$key = $value;

        return $model;
    }

    /**
     * Найти удалить или изменить уведомление, связанное с удаленным комментарием
     * @param $comment
     */
    public function fixCommentNotification($comment)
    {
        $cursor = $this->getCollection()->find(array(
            'type' => $this->type,
            'entity' => $comment->entity,
            'entity_id' => (int)$comment->entity_id,
        ));

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

    public function getText()
    {
        switch ($this->entity) {
            case 'CommunityContent':
            case 'BlogContent':
                if ($this->getEntity() === null)
                    return 'запись не найдена';
                switch ($this->getEntity()->type_id) {
                    case CommunityContent::TYPE_POST:
                        return 'к вашей записи добавлены новые комментарии';
                    case CommunityContent::TYPE_VIDEO:
                        return 'к вашему видео добавлены новые комментарии';
                    case CommunityContent::TYPE_STATUS:
                        return 'к вашему статусу добавлены новые комментарии';
                }
                return 'к вашей записи добавлены новые комментарии';
                break;

            case 'CookRecipe':
                return 'к вашему рецепту добавлены новые комментарии';
            case 'AlbumPhoto':
                return 'к вашему фото добавлены новые комментарии';
            default:
                return 'к вашей записи добавлены новые комментарии';
                break;
        }
    }
}