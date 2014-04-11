<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 11/04/14
 * Time: 12:34
 * To change this template use File | Settings | File Templates.
 */

class JabberLogRoute extends CLogRoute
{
    public $room;
    public $name;
    public $file;

    protected function processLogs($logs)
    {
        foreach ($logs as $log) {
            $this->sendMessage($log[0]);
        }
    }

    protected function sendMessage($message)
    {
        $params = array(
            '-f' => $this->file,
            '-r' => $this->name,
            '--chatroom' => $this->room,
        );

        $str = 'echo "' . $message . '" | sendxmpp';
        foreach ($params as $k => $v) {
            $str .= ' ' . $k . ' ' . $v;
        }

        shell_exec($str);
    }
}