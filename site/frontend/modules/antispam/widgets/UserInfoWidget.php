<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 20/01/14
 * Time: 10:53
 * To change this template use File | Settings | File Templates.
 */

class UserInfoWidget extends CWidget
{
    /**
     * @var User $user
     */
    public $user;

    public function run()
    {
        $counts = $this->getCounts();

        $this->render('UserInfoWidget', compact('counts'));
    }

    protected function getCounts()
    {
        $statuses = array(AntispamCheck::STATUS_UNDEFINED, AntispamCheck::STATUS_GOOD, AntispamCheck::STATUS_BAD);
        $counts = array();
        foreach ($statuses as $status)
            $counts[$status] = 0;
//            $counts[$status] = AntispamCheck::model()->user($this->user->id)->status($status)->count();
        return $counts;
    }
}