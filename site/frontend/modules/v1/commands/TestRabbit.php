<?php

namespace site\frontend\modules\v1\commands;

use AMQPConnection;
use AMQPChannel;
use AMQPExchange;

class TestRabbit extends \CConsoleCommand
{

    public function actionIndex()
    {
        \Yii::app()->rabbit->send('{"TEST":2}');
        /*$rabbit = new AMQPConnection(array('host' => '127.0.0.1', 'port' => '5672', 'login' => 'guest', 'password' => 'guest'));
        $rabbit->connect();

        $testChannel = new AMQPChannel($rabbit);
        $testExchange = new AMQPExchange($testChannel);

        $testExchange->setName('hg2api');
        $testExchange->publish('{"TEST": 2}', 'route_to_everybody');

        $rabbit->disconnect();*/
    }
}