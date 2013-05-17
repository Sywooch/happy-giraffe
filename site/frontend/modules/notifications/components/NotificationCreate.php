<?php
/**
 * Класс для создания уведомления. Уведомления создаем всегда, потом уже выбираем что отображать
 * (и что идет в счетчик) в зависимости от конкретного пользователя.
 *
 * Уведомление всегда создается сразу, но отобразиться может и позже.
 * При создании уведомления на основе настроек пользователя, определяется время когда это уведомление будет показано.
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationCreate
{
    /**
     * Создаем уведомления, связынне с появлением нового комментария. Это могут быть:
     * 1. уведомления автору поста
     * 2. уведомление если кому-то ответил на его коммент
     * 3. уведомления тем кто комментировал тему
     * @param $comment Comment
     */
    public static function commentCreated($comment)
    {
        $entity = $comment->entity;
        $model = $entity::model()->findByPk($comment->entity_id);

        //если пишет автор, пропускаем
        if (isset($model->author_id) && $model->author_id == $comment->author_id)
            return;

        self::userContentNotification($model, $comment);
        self::replyCommentNotification($comment);
        //сначала подписываем автора, это избавит от лишней проверки на следующем шаге
        //когда будет выбирать всех подписчиков кроме того кто только что написал
        NotificationDiscussSubscription::model()->subscribeCommentAuthor($comment);
        self::addCommentToDiscussNotifications($comment);
    }

    /**
     * Создание уведомления автору поста
     *
     * @param $model CActiveRecord запись/фото/видео
     * @param $comment Comment
     */
    private static function userContentNotification($model, $comment)
    {
        if (isset($model->author_id) && $comment->author_id !== User::HAPPY_GIRAFFE) {
            $notification = new NotificationUserContentComment;
            $notification->create($model->author_id, $comment);
        }
    }

    /**
     * Создание уведомление об ответе на комментарий
     *
     * @param $comment Comment
     */
    private static function replyCommentNotification($comment)
    {
        if (!empty($comment->response_id) || !empty($comment->quote_id)) {
            $notification = new NotificationReplyComment();
            $response = empty($comment->response_id) ? $comment->quote : $comment->response;
            $notification->create($comment, $response);
        }
    }

    /**
     * Создание уведомления о продолжении дискуссии
     *
     * @param $user_id
     * @param $entity
     * @param $entity_id
     * @param $last_read_comment_id
     */
    public static function discussContinue($user_id, $entity, $entity_id, $last_read_comment_id)
    {
        $notification = new NotificationDiscussContinue();
        $notification->create($user_id, $entity, $entity_id, $last_read_comment_id);
    }

    /**
     * Добавляет новый комментарий в уведомления пользователей о продолжении дискуссии
     *
     * @param $comment Comment
     */
    private function addCommentToDiscussNotifications($comment)
    {
        $subscribes = NotificationDiscussContinue::model()->findUnreadDiscussNotifications($comment->entity, $comment->entity_id);
        foreach ($subscribes as $subscribe) {
            $subscribe->update($subscribe, $comment->id);
        }
    }

    /**
     * Создаем уведомления о лайках за последние 24 часа
     *
     */
    public static function generateLikes()
    {
        $result = array();
        $likes = RatingYohoho::model()->findLastDayLikes();
        echo count($likes);

        foreach ($likes as $like) {
            $model = CActiveRecord::model($like['entity_name'])->findByPk($like['entity_id']);

            if (!isset($result[$model->author_id]))
                $result[$model->author_id] = array();
            if (!isset($result[$model->author_id][$like['entity_name']]))
                $result[$model->author_id][$like['entity_name']] = array();
            if (!isset($result[$model->author_id][$like['entity_name']][$like['entity_id']]))
                $result[$model->author_id][$like['entity_name']][$like['entity_id']] = 0;

            $result[$model->author_id][$like['entity_name']][$like['entity_id']]++;
        }

        //для каждого автора выберем 10 топовых статей
        foreach ($result as $author_id => $contents) {
            $author_articles = array();
            $likes_count = 0;
            foreach ($contents as $entity => $ids)
                foreach ($ids as $id => $count) {
                    $author_articles [] = array($entity, $id, $count);
                    $likes_count++;
                }

            usort($author_articles, array('NotificationCreate', 'compareLikesCount'));
            array_slice($author_articles, 0, 10);

            //создаем уведомление для автора
            $favourite_articles = array();
            foreach ($author_articles as $author_article) {
                $favourite_articles [] = array(
                    'entity' => $author_article[0],
                    'entity_id' => (int)$author_article[1],
                    'count' => (int)$author_article[2],
                );
            }

            $notification = new NotificationLike();
            $notification->create($author_id, $favourite_articles, $likes_count);
        }

        //echo microtime(true) - $t;
    }

    function compareLikesCount($a, $b)
    {
        if ($a[2] == $b[2]) {
            return 0;
        }
        return ($a[2] < $b[2]) ? 1 : -1;
    }
}