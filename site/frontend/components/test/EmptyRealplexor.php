<?php
/**
 * Заглушка для локальной работы
 *
 * @version 1.31
 */
class EmptyRealplexor
{
    public $host = '';
    public $port = 10010;
    public $namespace = null;
    public $identifier = "identifier";

    public function init()
    {

    }

    public function logon($login, $password)
    {

    }

    public function send($idsAndCursors, $data, $showOnlyForIds = null)
    {

    }

    public function cmdOnlineWithCounters($idPrefixes = null)
    {

    }


    public function cmdOnline($idPrefixes = null)
    {

    }


    public function cmdWatch($fromPos, $idPrefixes = null)
    {

    }
}