<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/07/14
 * Time: 10:58
 */

class AdaptiveWidget extends CWidget
{
    public $exclude;

    public function init()
    {
        ob_start();
    }

    public function run()
    {
        $contents = ob_get_clean();
        if ($this->isShown()) {
            echo $contents;
        }
    }

    protected function isShown()
    {
        if ($this->exclude === null) {
            return true;
        }
        if (! is_array($this->exclude)) {
            $this->exclude = array($this->exclude);
        }
        return ! in_array(Yii::app()->vm->getVersion(), $this->exclude);
    }
} 