<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HJsLogger
 *
 * @author Кирилл
 */
class HJsLogger extends CComponent
{
    public $settings = false;


    public function init()
    {
        $cs = Yii::app()->clientScript;
        if($this->settings)
            $cs->registerScript('muscula', $this->getJS(), CClientScript::POS_HEAD);
    }
    
    public function getJS()
    {
        $settings = CJSON::encode($this->settings);
        return <<<JS
        window.Muscula = {settings: $settings };
        (function () {
            var m = document.createElement('script'); m.type = 'text/javascript'; m.async = true;
            m.src = (window.location.protocol == 'https:' ? 'https:' : 'http:') +
            '//musculahq.appspot.com/Muscula7.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(m, s);
            window.Muscula.run=function(){var a;eval(arguments[0]);window.Muscula.run=function(){};};
            window.Muscula.errors=[];window.onerror=function(){window.Muscula.errors.push(arguments);
            return window.Muscula.settings.suppressErrors===undefined;}
        })();
JS;
    }
}

?>
