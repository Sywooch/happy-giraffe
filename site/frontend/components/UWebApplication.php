<?php

class UWebApplication extends CWebApplication
{
    public function __construct($config=null)
    {
        parent::__construct($config);
        register_shutdown_function(array($this, 'shutdown'));
    }

    public function shutdown()
    {
        if (YII_ENABLE_ERROR_HANDLER && ($error = error_get_last())) {
            $this->handleError($error['type'], $error['message'], $error['file'], $error['line']);
            die();
        }
    }
}