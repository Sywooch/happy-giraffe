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
}