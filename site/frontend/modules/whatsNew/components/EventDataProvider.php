<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/4/12
 * Time: 12:43 PM
 * To change this template use File | Settings | File Templates.
 */
class EventDataProvider extends CSqlDataProvider
{
    protected function fetchData()
    {
        $_data = parent::fetchData();

        $data = array();
        foreach ($_data as $k => $v) {
            $event = Event::factory($v['type']);
            $event->attributes = $v;
            $data[$k] = $event;
        }

        return $data;
    }
}
