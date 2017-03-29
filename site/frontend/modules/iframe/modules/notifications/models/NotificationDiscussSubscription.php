<?php
/**
 * Подписка на контент
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationDiscussSubscription extends HMongoModel
{
    protected $_collection_name = 'notification_discuss_subs';

    /**
     * @var NotificationDiscussSubscription
     */
    private static $_instance;

    public function __construct()
    {
    }

    /**
     * @return NotificationDiscussSubscription
     */
    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Добавляет индекс если не создан
     */
    public function ensureIndex()
    {
        $this->getCollection()->ensureIndex(array(
            'time' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'time_index'));

        $this->getCollection()->ensureIndex(array(
            'entity' => EMongoCriteria::SORT_DESC,
            'entity_id' => EMongoCriteria::SORT_DESC,
            'subscriber_id' => EMongoCriteria::SORT_DESC,
        ), array('name' => 'user_subscription_index'));
    }

    /**
     * Возвращает список подписчиков темы, которые должны получить уведомление о
     * новых комментариях в теме, то есть те после посещения которых было написано
     * более 10 новых комментариев.
     *
     * Удаляет подписки, так как пользователям будут отправлены уведомления и они
     * больше не будут подписаны
     *
     * @param $comment Comment
     * @return array массив пользователей user_id => last_read_comment_id
     */
    public function getSubscribers($comment)
    {
        $last_read_comment = $this->getLastReadComment($comment);
        if ($last_read_comment === null)
            return array();

        $cursor = $this->getCollection()->find(array(
            'entity' => $comment->entity,
            'entity_id' => (int)$comment->entity_id,
            'last_read_comment_id' => array('$lt' => (int)$last_read_comment->id)
        ), array('subscriber_id', 'last_read_comment_id'));

        //var_dump($cursor->explain());

        $list = array();
        while ($cursor->hasNext()) {
            $subscriber = $cursor->getNext();
            $list [$subscriber['subscriber_id']] = $subscriber['last_read_comment_id'];
            $this->deleteByPk($subscriber['_id']);
        }

        return $list;
    }

    /**
     * Возвращает последний комментарий, который если был прочитан пользователем, то он
     * получит уведомление. Основывается на том что id комментариев увеличивается и те кто
     * прочитал этот комментарий или любой из предыдущих с меньшим id, получат уведомления
     *
     * @param $comment
     * @return CActiveRecord
     */
    private function getLastReadComment($comment)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('entity', $comment->entity);
        $criteria->compare('entity_id', $comment->entity_id);
        $criteria->compare('removed', 0);
        $criteria->order = 'id desc';
        $criteria->offset = NotificationDiscussContinue::NEW_COMMENTS_COUNT;
        return Comment::model()->find($criteria);
    }

    /**
     * Подписываем автора комментария на продолжение дискуссии. Если он уже
     * подписан, меняем last_read_comment_id и time
     *
     * @param $comment
     */
    public function subscribeCommentAuthor($comment)
    {
        $this->ensureIndex();

        $entity = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
        if ($entity === null)
            return ;

        $exist = $this->getCollection()->findOne(array(
            'entity' => $comment->entity,
            'entity_id' => (int)$comment->entity_id,
            'subscriber_id' => (int)$comment->author_id
        ));

        if (empty($exist)) {
            $this->getCollection()->insert(array(
                'entity' => $comment->entity,
                'entity_id' => (int)$comment->entity_id,
                'subscriber_id' => (int)$comment->author_id,
                'last_read_comment_id' => (int)$comment->id,
                'time' => time()
            ));
        } else {
            $this->getCollection()->update(array(
                '_id' => $exist['_id']
            ), array(
                '$set' => array(
                    'last_read_comment_id' => (int)$comment->id,
                    'time' => time()
                )
            ));
        }
    }

    /**
     * Создаем уведомления о продожении дискуссии пользователям, которые были
     * подписаны на дискуссию более чем сутки назад
     */
    public function createDiscussNotifications()
    {
        $cursor = $this->getCollection()->find(array(
            'time' => array('$lt' => (time() - 3600 * 24))
        ));

        while ($cursor->hasNext()) {
            $subscription = $cursor->getNext();

            //если в теме есть новые комментарии и их кол-во больше лимита, создаем уведомление
            $new_comments_count = Comment::getNewCommentsCount($subscription['entity'], $subscription['entity_id'], $subscription['last_read_comment_id']);
            if ($new_comments_count >= NotificationDiscussContinue::NEW_COMMENTS_COUNT)
                NotificationCreate::discussContinue(
                    $subscription['subscriber_id'],
                    $subscription['entity'],
                    $subscription['entity_id'],
                    $subscription['last_read_comment_id']
                );

            //удаляем подписку
            $this->deleteByPk($subscription['_id']);
        }
    }
}