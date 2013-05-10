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
class NotificationCreate{

    /**
     * Создаем уведомления, связынне с появлением нового комментария. Это могут быть:
     * 1. уведомления автору поста
     * 2. уведомление если кому-то ответил на его коммент
     * 3. уведомления тем кто комментировал тему
     * @param $comment Comment
     */
    public static function commentCreated($comment)
    {
        //уведомления автору поста
        if ($comment->author_id !== User::HAPPY_GIRAFFE){
            $notification = new NotificationUserContentComment;
            $notification->create($comment);
        }
        //уведомление если кому-то ответил на его коммент
        if (!empty($comment->response_id)){
            $notification = new NotificationReplyComment();
            $notification->create($comment);
        }
    }

    /**
     * Создаем уведомление для автора поста о новом лайке его статьи
     *
     * @param RatingYohoho $like
     */
    public static function likeCreated($like)
    {
        $model = CActiveRecord::model($like->entity_name)->findByPk($like->entity_id);
        //уведомления автору поста
        if ($model->author_id !== User::HAPPY_GIRAFFE){
            $notification = new NotificationLike();
            $notification->create($model->author_id, $like);
        }
    }
}