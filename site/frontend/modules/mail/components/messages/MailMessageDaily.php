<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/04/14
 * Time: 14:26
 * To change this template use File | Settings | File Templates.
 */

class MailMessageDaily extends MailMessage
{
    public $type = 'daily';

    /**
     * Рецепт
     *
     * @property CookRecipe $recipe
     */
    public $recipe;

    /**
     * Гороскоп на сегодня
     *
     * @property Horoscope $horoscope
     */
    public $horoscope;

    /**
     * Фотопост
     *
     * @property CommunityContent $photoPost
     */
    public $photoPost;

    /**
     * Обычные посты
     *
     * @property CommunityContent[] $posts
     */
    public $posts = array();

    /**
     * Количество непрочитанных сообщений
     *
     * @property int $newMessagesCount
     */
    public $newMessagesCount;

    /**
     * Количество новых комментариев
     *
     * @property int $newCommentsCount
     */
    public $newCommentsCount;

    /**
     * Количество запросов дружбы
     *
     * @property int $newFriendsCount
     */
    public $newFriendsCount;

    /**
     * Количество лайков
     *
     * @property int $newLikesCount
     */
    public $newLikesCount;

    /**
     * Количество добавлений в избранное
     *
     * @property int $newFavouritesCount
     */
    public $newFavouritesCount;


    public function getSubject()
    {
        return time();
    }

    public function getTitle()
    {
        return 'Здравствуйте, ' . $this->user->first_name . '! В Вашем профиле появились новые события.';
    }

    public function getMessagesUrlParams()
    {
        if ($this->newMessagesCount > 0) {
            $contacts = ContactsManager::getContactsForDelivery($this->user->id, 1);
            $contact = $contacts[0];
            return array('/messaging/default/index', 'interlocutorId' => $contact->user->id);
        }
    }

    public function getFriendsUrlParams()
    {
        return array('/friends/default/index', 'tab' => 2);
    }

    public function getLikesUrlParams()
    {
        return array('/notifications/default/index');
    }

    public function getFavouritesUrlParams()
    {
        return array('/notifications/default/index');
    }

    public function getCommentsUrlParams()
    {
        return array('/notifications/default/index');
    }
}