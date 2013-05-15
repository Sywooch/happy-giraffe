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
        if (!empty($comment->response_id) && $comment->response->author_id != $comment->author_id) {
            $notification = new NotificationReplyComment();
            $notification->create($comment);
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
     * Создаем уведомление для автора поста о новом лайке его статьи
     *
     * @param RatingYohoho $like
     */
    public static function likeCreated($like)
    {
        $entity = $like->entity_name;
        $model = $entity::model()->findByPk($like->entity_id);
        //уведомления автору поста
        if ($model->author_id !== User::HAPPY_GIRAFFE && $model->author_id != Yii::app()->user->id) {
            $notification = new NotificationLike();
            $notification->create($model->author_id, $like);
        }
    }

    /**
     * Создаем уведомления о лайках за последние 24 часа
     *
     */
    public static function generateLikes()
    {
        $entity = $like->entity_name;
        $model = $entity::model()->findByPk($like->entity_id);
        //уведомления автору поста
        if ($model->author_id !== User::HAPPY_GIRAFFE && $model->author_id != Yii::app()->user->id) {
            $notification = new NotificationLike();
            $notification->create($model->author_id, $like);
        }
    }
}