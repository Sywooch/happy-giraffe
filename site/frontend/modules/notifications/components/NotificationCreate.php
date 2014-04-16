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

        self::userContentNotification($model, $comment);
        self::replyCommentNotification($model, $comment);

        //Проверяем является ли автор комментария автором блога
        if (!isset($entity->author_id) || $entity->author_id != $comment->author_id)
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
        if (isset($model->author_id) && $comment->author_id !== User::HAPPY_GIRAFFE && $comment->author_id !== $model->author_id) {
            $notification = new NotificationUserContentComment;
            $notification->create($model->author_id, $comment);
        }
    }

    /**
     * Создание уведомление об ответе на комментарий
     *
     * @param $model CActiveRecord запись/фото/видео
     * @param $comment Comment
     */
    private static function replyCommentNotification($model, $comment)
    {
        if (!empty($comment->response_id)) {
            //если отвечает автору контента - не создаем уведомление, так как он
            //получит уведомление о новом комментарии к своему контенту
            if ($comment->response->author_id == $model->author_id)
                return ;

            $notification = new NotificationReplyComment();
            $notification->create($comment, $comment->response);
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
     * Создаем summary-уведомление о лайках за последние 24 часа
     *
     */
    public static function generateLikes()
    {
        $data = HGLike::model()->findLastDayAuthorContentLikes();
        return self::generateSummaryNotification($data, 'NotificationLikes');
    }

    /**
     * Создаем summary-уведомление об избранном за последние 24 часа
     */
    public static function generateFavourites()
    {
        $data = Favourite::model()->findLastDayFavourites();
        self::generateSummaryNotification($data, 'NotificationFavourites');
    }

    /**
     * Создаем summary-уведомление об избранном за последние 24 часа
     */
    public static function generateReposts()
    {
        $data = CommunityContent::model()->findLastDayReposts();
        self::generateSummaryNotification($data, 'NotificationReposts');
    }

    /**
     * @param array $data
     * @param string $notificationName
     */
    public static function generateSummaryNotification($data, $notificationName)
    {
        //для каждого автора выберем 10 топовых статей
        foreach ($data as $author_id => $contents) {
            $author_articles = array();
            $all_count = 0;
            foreach ($contents as $entity => $ids)
                foreach ($ids as $id => $count) {
                    $author_articles [] = array($entity, $id, $count);
                    $all_count += $count;
                }

            usort($author_articles, array('NotificationCreate', 'compareCount'));

            //создаем уведомление для автора
            $favourite_articles = array();
            foreach ($author_articles as $author_article) {
                $favourite_articles [] = array(
                    'entity' => $author_article[0],
                    'entity_id' => (int)$author_article[1],
                    'count' => (int)$author_article[2],
                );
            }

            $notification = new $notificationName;
            $notification->create($author_id, $favourite_articles, $all_count);
        }
    }

    function compareCount($a, $b)
    {
        if ($a[2] == $b[2]) {
            return 0;
        }
        return ($a[2] < $b[2]) ? 1 : -1;
    }
}