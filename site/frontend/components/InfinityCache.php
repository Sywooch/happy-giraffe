<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InfinityCache
 *
 * @author Кирилл
 */
class InfinityCache extends CDbCache
{
	/**
	 * Initializes this application component.
	 *
	 * This method is required by the {@link IApplicationComponent} interface.
	 * It ensures the existence of the cache DB table.
	 * It also removes expired data items from the cache.
	 */
	public function init()
	{
		if($this->autoCreateCacheTable)
		{
            $this->autoCreateCacheTable = false;
            parent::init();
            $this->autoCreateCacheTable = true;
            
            $db=$this->getDbConnection();
            $db->setActive(true);
			$sql="SELECT * FROM {$this->cacheTableName} WHERE 1 LIMIT 1;";
			try
			{
				$db->createCommand($sql)->execute();
			}
			catch(Exception $e)
			{
				$this->createCacheTable($db,$this->cacheTableName);
			}
		} else {
            parent::init();
        }
	}
    
    /**
     * Запрещаем удаление данных из таблицы
     */
    protected function gc()
    {
        return;
    }

}
