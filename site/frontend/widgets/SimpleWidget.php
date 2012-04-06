<?php
/**
 * Author: alexk984
 * Date: 06.04.12
 */
class SimpleWidget extends CWidget
{
    public $viewFile;

    public function run()
    {
        if($this->viewFile === null)
            $this->viewFile = get_class($this);
        $this->render($this->viewFile);
    }
}