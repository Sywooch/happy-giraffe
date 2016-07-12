<?php

namespace site\frontend\modules\posts\modules\blogs;

/**
 * @author Sergey Gubarev
 */
class BlogsModule extends \CWebModule
{
    
    /**
     * Конфиги
     * 
     * @var array
     */
    private $_config = array();
    
    /**
     * @var string
     */
    public $controllerNamespace = 'site\frontend\modules\posts\modules\blogs\controllers';
    
    //-----------------------------------------------------------------------------------------------------------
    
    /**
     * {@inheritDoc}
     * @see CModule::init()
     */
    public function init()
    {
        parent::init();
        
        $this->_config = require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '/config/main.php';
    }
    
    /**
     * Получить нужный конфиг модуля
     * 
     * @param string $name
     * @return NULL|mixed
     */
    public function getConfig($name)
    {
        if (empty($this->_config) || ! array_key_exists($name, $this->_config))
        {
            return NULL;  
        }
       
        return $this->_config[$name];
    }
    
}