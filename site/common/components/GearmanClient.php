<?php
/**
 * insert Description
 * 
 * @author Alex Kireev <alexk984@gmail.com>
 */

class CGearmanClient extends CApplicationComponent{
    protected $client = null;


    /**
     * @brief Initialize component.
     * @details in case fakeMode is enabled loading fake Queue and Exchange classes
     */
    public function init()
    {
        $this->client = new GearmanClient();
        $this->client->addServer();

        parent::init();
    }

    public function sender($text)
    {
        $this->client->addTask("reverse", $text, null, "1");
    }

    public function receiver()
    {
        $worker = new GearmanWorker();
        $worker->addServer();
        $worker->addFunction("reverse", array($this, "processMessage"));
        while ($worker->work());
    }

    public function processMessage($job)
    {
        return strrev($job->workload());
    }

}