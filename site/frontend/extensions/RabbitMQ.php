<?php

class RabbitMQ
{
/*    public $rabbit;
    public $host;
    public $port;
    public $login;
    public $password;

    public function init() {
        $this->rabbit = new AMQPConnection(array(
            'host' => $this->host,
            'port' => $this->port,
            'login' => $this->login,
            'password' => $this->password
        ));
    }

    public function send($message) {
        $this->rabbit->connect();

        $channel = new AMQPChannel($this->rabbit);
        $exchange = new AMQPExchange($channel);

        $exchange->setName('');
        $exchange->publish($message, 'route_to_everybody');

        $this->rabbit->disconnect();
    }*/
}