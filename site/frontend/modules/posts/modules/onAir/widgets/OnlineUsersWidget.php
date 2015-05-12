<?php
namespace site\frontend\modules\posts\modules\onAir\widgets;

/**
 * @author Никита
 * @date 27/04/15
 */

class OnlineUsersWidget extends \CWidget
{
    const LIMIT = 36;

    public function run()
    {
        $this->render('OnlineUsersWidget', array('users' => $this->getUsers()));
    }

    protected function getUsers()
    {
        return \User::model()->cache(300)->findAll(array(
            'condition' => 'avatar_id IS NOT NULL',
            'limit' => self::LIMIT,
            'order' => 'online DESC, login_date DESC',
        ));
    }
}