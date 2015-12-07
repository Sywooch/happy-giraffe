<?php

class NginxStream
{
    public $host;
    public $port;

    public function init()
    {
        \Yii::log('nginx stream init', ' info', 'nginx');

        $this->host = $this->host.":".$this->port."/pub/";
    }

    public function send($channel, $data)
    {
        if ($curl = curl_init()) {
            $this->host = $this->host . $channel;

            curl_setopt($curl, CURLOPT_URL, $this->host);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            if (!curl_exec($curl)) {
                throw new NginxStreamException('Send failed!:' . curl_error($curl) . ' Code: ' . curl_errno($curl)
                    . ' in ' . curl_getinfo($curl, CURLINFO_EFFECTIVE_URL)
                    . ' data: ' . curl_getinfo($curl, CURLINFO_HEADER_OUT)
                );
            }

            curl_close($curl);
        }
        else {
            throw new NginxStreamException('Failed to initialize curl!');
        }
    }
}

class NginxStreamException extends Exception
{

}

