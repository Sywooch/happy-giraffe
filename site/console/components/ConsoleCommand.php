<?php

/**
 * @author Никита
 * @date 04/12/14
 */

class ConsoleCommand extends CConsoleCommand
{
    public function init()
    {
        Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        parent::init();
    }
} 