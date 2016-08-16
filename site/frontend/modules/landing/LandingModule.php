<?php

namespace site\frontend\modules\landing;

/**
 * Модуль для "лендингов"
 *
 * @author Sergey Gubarev
 */
class LandingModule extends \CWebModule
{
    
    /**
     * {@inheritDoc}
     * @see CModule::init()
     */
    public function init()
    {        
        $this->setModules([
            'pediatrician' => [
                'class' => 'site\frontend\modules\landing\modules\pediatrician\PediatricianModule',
            ],
        ]);
    }
    
}