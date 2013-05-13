<?php
/**
 * Отвечает за прочитанность уведомления. Когда пользователь посетил страницу уведомления
 * связанные с этой страницей должны пометиться как прочитанные с учетом страницы комментариев
 *
 * Если пользователь смотрит 1-ю страницу (25 комментариев), то прочитанными помечаются только
 * эти комментарии, комментарии на других страницах считаются не прочитанными.
 * Учитывая текущую структуру вывода постов, реализуем это условие таким способом:
 * 1. устанавливаем модель просматриваемого контента
 * 2. добавляем все комментарии которые выводятся (именно они должны считаться как прочитанные)
 * 3. Запускаем проверку.
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class NotificationRead
{
    /**
     * @var NotificationRead
     */
    private static $_instance;

    /**
     * Контент, который открыл пользователь
     * @var CActiveRecord
     */
    private $content_model;
    /**
     * Список комментариев, которые открыл пользователь - только их считаем прочитанными
     * @var Comment[]
     */
    private $comments = array();
    /**
     * Список id комментариев, которые открыл пользователь - только их считаем прочитанными
     * @var int[]
     */
    private $comment_ids = array();

    /**
     * @return NotificationRead
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct()
    {
    }

    /**
     * Запомнить просматриваемый пользователем контент
     * @param $content_model CActiveRecord
     */
    public function setContentModel($content_model)
    {
        $this->content_model = $content_model;
    }

    /**
     * Добавить комментарий в список для пометки его как прочитанного
     * @param $comment
     */
    public function addShownComment($comment)
    {
        $this->comments [] = $comment;
    }

    /**
     * Ранее заданный контент просмотрен пользователем. Запускается после того как добавим
     * модель контента и все комментарии к нему
     *
     * Проверяются следующие уведомления на прочитанность
     * 1. Комментарии на личный контент - если автор
     * 2. Ответы на комментарии
     * 3. Обсуждения
     *
     */
    public function SetVisited()
    {
        if ($this->hasNoActiveNotifications() || empty($this->comments))
            return;

        if ($this->content_model->author_id == Yii::app()->user->id)
            $this->checkOwnContent();
    }

    /**
     * Проверяем есть ли у пользователя непрочитанные уведомления - должно повысить время
     * откликак страницы с учетом предположения что в большинстве случаев все уведолмнеия прочитаны
     * @return bool
     */
    private function hasNoActiveNotifications()
    {
        return (Notification::model()->getUnreadCount() == 0);
    }

    /**
     * Проверка уведолмений о комментариях на личный контент
     */
    private function checkOwnContent()
    {
        //находим непрочитанное уведомление
        $model = NotificationUserContentComment::model()->findUnread(
            Yii::app()->user->id,
            get_class($this->content_model),
            $this->content_model->getPrimaryKey()
        );

        if ($model !== null) {
            $old_comments_count = $model->unread_model_ids;
            #TODO при удалении комментария, нужно удалять его из уведомлений
            foreach ($this->comment_ids as $comment_id) {
                $model->setCommentRead($comment_id);
            }

            //если что-то прочитал, сохраняем модель
            if ($old_comments_count > $model->unread_model_ids)
                $model->save();
        }
    }

    /**
     * Проверка уведомления об ответе на комментарий
     */
    private function checkCommentReply()
    {
        //находим непрочитанное уведомление
        $model = NotificationReplyComment::model()->findUnread(
            Yii::app()->user->id,
            get_class($this->content_model),
            $this->content_model->getPrimaryKey()
        );

        if ($model !== null) {
            $old_comments_count = $model->unread_model_ids;
            #TODO при удалении комментария, нужно удалять его из уведомлений
            foreach ($this->comment_ids as $comment_id) {
                $model->setCommentRead($comment_id);
            }

            //если что-то прочитал, сохраняем модель
            if ($old_comments_count > $model->unread_model_ids)
                $model->save();
        }
    }
}