<?php

class DefaultController  extends CController
{

    public $scenario = NULL;
    
    public function actionIndex()
    {
//        $files = CFileHelper::findFiles('protected\modules\delivery', array('fileTypes'=>'','level'=>0));
//	$directories = glob('protected\\modules\\delivery\\modules\\*', GLOB_ONLYDIR);
//	$modules = array();
//	foreach ($directories as $dir) {
//	    array_push($modules, substr($dir, 35));	    
//	}
	

        $this->render(__FUNCTION__, array(
	    'name'=>$this->getModule()->name,
//	    'files' => $files,
//	    'modules' => $modules
	    )
	);
    }
    
    /*
     * Здесь создаем в базе данных таблицу с настройками этого модуля
     */
    public function actionInstall() {
	
	$sql = 'CREATE TABLE IF NOT EXISTS  {{_delivery_courier}} (
		  `id` INTEGER  NOT NULL AUTO_INCREMENT,
		  `key` VARCHAR(255)  NOT NULL,
		  `value` VARCHAR(255)  NOT NULL,		  
		  PRIMARY KEY (`id`)
		) ENGINE = InnoDB
		CHARACTER SET utf8 COLLATE utf8_general_ci;';
	
	$connection=Yii::app()->db;
	$command=$connection->createCommand($sql);
	$command->execute();
	
//	$model = Yii::app()->controller->getModule('delivery')->loadDelivery($this->getModule()->name);
	$model=Delivery::model()->findByAttributes(array('delivery_name'), array('condition'=>'='.$model_name));
	    if($model===null)
		    throw new CHttpException(404,'The requested page does not exist.');
	    else {
		$model->delivery_is_install = 1;
		$model->update();
	    }
	
	$url = $this->createUrl('/delivery/'.$this->getModule()->name.'/default/index');
	$this->redirect($url);
    }

	
}
?>
