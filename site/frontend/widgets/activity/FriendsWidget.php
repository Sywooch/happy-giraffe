<?php
/**
 * Найти друзей
 *
 * Список пользователей с заполненными анкетами.
 *
 * Author: choo
 * Date: 15.05.2012
 */
class FriendsWidget extends CWidget
{
    public function run()
    {
        $friends = User::findFriends(2);
        $this->render('FriendsWidget', compact('friends'));
    }
}
