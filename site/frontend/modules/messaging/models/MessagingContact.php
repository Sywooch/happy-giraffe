<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 09/04/14
 * Time: 13:04
 * To change this template use File | Settings | File Templates.
 */

class MessagingContact
{
    /**
     * @property User $user
     */
    public $user;

    /**
     * @property int $unreadCount
     */
    public $unreadCount;

    public function __construct(User $user, $unreadCount)
    {
        $this->user = $user;
        $this->unreadCount = $unreadCount;
    }
}