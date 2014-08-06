<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YaSearchWidget
 *
 * @author Кирилл
 */
class YaSearchWidget extends CWidget
{

    public $view = 'yaSearch';

    public function run()
    {
        $this->registerScripts();
        $this->render($this->view);
    }

    public function registerScripts()
    {
        
    }

}

?>
