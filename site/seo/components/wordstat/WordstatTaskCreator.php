<?php
/**
 * Создает и добавляет задания в очередь
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class WordstatTaskCreator
{
    private $jobs = array();

    public function start()
    {
        $client = Yii::app()->gearman->client();
        for ($i = 0; $i < 20; $i++) {
            $text = 'task.' . $i;
            $job_handle = $client->doBackground("simple_parsing", serialize($text));
            if ($client->returnCode() != GEARMAN_SUCCESS){
                echo 'send task fail';
                Yii::app()->end();
            }
            $this->jobs [] = $job_handle;
        }

        while(1){
            sleep(1);
            foreach($this->jobs as $job_handle){
                $stat = $client->jobStatus($job_handle);
                var_dump($stat);
            }
        }
    }
}