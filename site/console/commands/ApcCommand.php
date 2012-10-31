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
        apc_clear_cache();
        apc_clear_cache('user');
        apc_clear_cache('opcode');
        clearstatcache();
    }
}