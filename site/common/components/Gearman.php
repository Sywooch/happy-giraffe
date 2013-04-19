<?php
/**
 * insert Description
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class Gearman extends CApplicationComponent
{
    public $servers;
    protected $client;
    protected $worker;

    public function init()
    {
        parent::init();
    }

    protected function setServers($instance)
    {
        if (empty($this->servers)){
            var_dump($this->servers);
            $instance->addServer();
        }

        foreach ($this->servers as $s){
            var_dump($this->servers);
            $instance->addServer($s['host'], $s['port']);
        }

        return $instance;
    }

    public function client()
    {
        if (!$this->client)
            $this->client = $this->setServers(new GearmanClient());

        return $this->client;
    }

    public function worker()
    {
        if (!$this->worker)
            $this->worker = $this->setServers(new GearmanWorker());

        return $this->worker;
    }
}