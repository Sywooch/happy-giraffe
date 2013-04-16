<?php
/**
 * insert Description
 * 
 * @author Alex Kireev <alexk984@gmail.com>
 */

class AMQClient extends CApplicationComponent{
    public $host      = 'localhost';
    public $port      = '5672';
    public $vhost     = '/';

    public $login     = 'guest';
    public $password  = 'guest';

    protected $client = null;

    /**
     * @brief Initialize component.
     * @details in case fakeMode is enabled loading fake Queue and Exchange classes
     */
    public function init()
    {
        $this->client = new AMQPConnection(array(
            'host'     => $this->host,
            'vhost'    => $this->vhost,
            'port'   => $this->port,
            'login'    => $this->login,
            'password' => $this->password,
        ));
        //Autoconnect for pecl extension
        if (method_exists($this->client, 'connect')&&$this->client->isConnected()==false)
            $this->client->connect();


        parent::init();
    }

    /**
     * @brief Declares a new Exchange on the broker
     * @param $name
     * @param $flags
     */
    public function declareExchange($name, $type = AMQP_EX_TYPE_DIRECT, $flags = NULL)
    {
        $ex = new AMQPExchange($this->client);
        return $ex->declare($name, $type, $flags);
    }

    /**
     * @brief Declares a new Queue on the broker
     * @param $name
     * @param $flags
     */
    public function declareQueue($name, $flags = NULL)
    {
        $queue = new AMQPQueue($this->client);
        return $queue->declare($name, $flags);
    }

    /**
     * @brief
     * @details Returns an instance of CAMQPExchange for exchange a queue is bind
     * @param $exchange
     * @param $queue
     * @param $routingKey
     */
    public function bindExchangeToQueue($exchange, $queue, $routingKey = "")
    {
        $exchange = $this->exchange($exchange);
        $exchange->bind($queue, $routingKey);
        return $exchange;
    }

    /**
     * @brief Binds a queue to specified exchange
     * @details Returns an instance of CAMQPQueue for queue an exchange is bind
     * @param $queue
     * @param $exchange
     * @param $routingKey
     */
    public function bindQueueToExchange($queue, $exchange, $routingKey = "")
    {
        $queue = $this->queue($queue);
        $queue->bind($exchange, $routingKey);
        return $queue;
    }

    /**
     * @brief Get exchange by name
     * @param $name  name of exchange
     * @return  object AMQPExchange
     */
    public function exchange($name)
    {
        return new AMQPExchange($this->client, $name);
    }

    /**
     * @brief Get queue by name
     * @param $name  name of exchange
     * @return  object AMQPQueue
     */
    public function queue($name)
    {
        return new AMQPQueue($this->client, $name);
    }

    /**
     * Returns AMQPConnection instance
     *
     * @return AMQPConnection
     */
    public function getClient()
    {
        return $this->client;
    }
}