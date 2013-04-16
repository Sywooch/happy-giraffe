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
        foreach ($this->servers as $s)
        {
            $instance->addServer($s['host'], $s['port']);
        }

        return $instance;
    }

    public function client()
    {
        if (!$this->client)
        {
            $this->client = $this->setServers(new GearmanClient());
        }

        return $this->client;
    }

    public function worker()
    {
        if (!$this->worker)
        {
            $this->worker = $this->setServers(new GearmanWorker());
        }

        return $this->worker;
    }

    public function sender($text)
    {
        $this->client()->doBackground("reverse", serialize($text));
    }

    public function receiver()
    {
        $this->worker()->addFunction("reverse", array($this, "processMessage"));
        while ($this->worker()->work());
    }

    public function processMessage($job)
    {
        echo $job->workload();
    }
}