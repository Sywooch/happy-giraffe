<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/29/12
 * Time: 11:18 AM
 * To change this template use File | Settings | File Templates.
 */
class EventDecor extends Event
{
    protected $clusterable = true;

    public function getDecorations()
    {
        return CookDecoration::model()->lastDecorations;
    }
}
