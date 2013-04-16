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
    protected $channel = null;
    protected $queue = null;
    protected $exchange = null;


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

        $this->channel = new AMQPChannel($this->client);

        parent::init();
    }

    public function sender($text, $route_key, $exchange)
    {
        if ($this->exchange === null){
            $this->exchange = new AMQPExchange($this->channel);
            $this->exchange->setName($exchange);
            $this->exchange->setType(AMQP_EX_TYPE_DIRECT);
            $this->exchange->declare();

        }
        $this->exchange->publish($text, $route_key);
    }

    public function receiver($exchange, $route_key, $queue_name)
    {
        if ($this->queue === null){
            $this->queue = new AMQPQueue($this->channel);
            $this->queue->setName($queue_name);
            $this->queue->declare();
            $this->queue->bind($exchange, $route_key);
        }
        $this->queue->consume(array($this, 'processMessage'));
    }

    private function processMessage($envelope, $queue)
    {
        echo "Message : " . $envelope->getBody() . "\n";
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