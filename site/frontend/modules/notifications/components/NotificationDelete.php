<?php
/**
 * Класс для удаленя уведомлений.
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationDelete
{
    /**
     * Удаляем или изменяем уведомления, связынне с комментарием. Это могут быть:
     * 1. уведомления автору поста
     * 2. уведомление если кому-то ответил на его коммент
     * 3. уведомление о продолжении дискуссии
     *
     * @param $comment Comment
     */
    public static function commentDeleted($comment)
    {
        NotificationUserContentComment::model()->fixCommentNotification($comment);
        NotificationReplyComment::model()->fixCommentNotification($comment);
        NotificationDiscussContinue::model()->fixCommentNotification($comment);
    }
}