<?php
/**
 * Author: alexk984
 * Date: 13.03.12
 */
class ApcCommand extends CConsoleCommand
{
    /**
     * Очистка кэша
     */
    public function actionIndex()
    {
        echo apc_clear_cache();
    }
}

