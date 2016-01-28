<?php

namespace site\frontend\extensions;

use AMQPConnection;
use AMQPChannel;
use AMQPExchange;

class RabbitMQ
{
    public $rabbit;
    public $host;
    public $port;
    public $login;
    public $password;

    public function init() {
        \Yii::log('rabbit init with host  = '
            . $this->host . ' port = '
            . $this->port . ' login = '
            . $this->login . ' password = '
            . $this->password, 'info', 'rabbit');

        if (!extension_loaded('amqp')) {
            dl('amqp.so');
        }

        /*echo print_r(get_loaded_extensions(), true);
        echo php_ini_loaded_file();*/

        try {
            $this->rabbit = new AMQPConnection(array(
                'host' => $this->host,
                'port' => $this->port,
                'login' => $this->login,
                'password' => $this->password
            ));
        } catch (Exception $e) {
            \Yii::log('rabbit init failed with ' . $e->getMessage(), 'info', 'rabbit');
        }

        \Yii::log('rabbit init end', 'info', 'rabbit');
    }

    public function send($message) {
        \Yii::log('send started', 'info', 'rabbit');
        $this->rabbit->connect();

        $channel = new AMQPChannel($this->rabbit);
        $exchange = new AMQPExchange($channel);

        $exchange->setName('hg2api');
        $exchange->publish($message, 'route_to_everybody');

        $this->rabbit->disconnect();
    }
}