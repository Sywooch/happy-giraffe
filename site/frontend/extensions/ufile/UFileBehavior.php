<?php


class UFileBehavior extends CActiveRecordBehavior {

	/*
	 * $fileAttributes:array of ($name=>array of params, $name, array('name'=>$name, ...params... )
	 */
	public $fileAttributes;
	public $fileItems = array(array());
	/*
	 * $fileItems = array(
	 *	'item'=>array(
	 *		'fileHandler'=>array($func, $param1, $param2, ... )	// $func($src, $dst, $params)
	 *   )
	 * )
	 */

	/**
	 * {} - model attributes
	 * <> - ufile attributes or special meta data
	 * * - file item id
	 */
	public	$fileName = 'files/{id}-<date><time><ms><rand><name>.<ext>';

	private $_attributes;
	private $_originValues;
	private $_savedValues;
	private $_new = false;


	public function  getAttributes()
	{
		if (!isset($this->_attributes)) {
			$this->_attributes = array();
			foreach($this->fileAttributes as $n=>$a) {
				if(is_int($n)) {
					$n = is_string($a) ?$a :$a['name'];
				}
				$this->_attributes[$n] = is_array($a) ?$a :array();
				if (!isset($this->_attributes[$n]['fileItems'])) {
					$this->_attributes[$n]['fileItems'] = $this->fileItems;
				}
				if (!isset($this->_attributes[$n]['fileName'])) {
					$this->_attributes[$n]['fileName'] = $this->fileName;
				}
			}
		}
		return $this->_attributes;
	}

	public function afterFind($event)
	{
		$model = $this->getOwner();
		foreach($this->getAttributes() as $name=>$params) {
			$this->_originValues[$name] = $model->$name;
			$model->$name = UFiles::getFileInstance($model->$name);
		}
	}

	public function beforeValidate($event)
	{
		$model = $this->getOwner();
		foreach($this->getAttributes() as $name=>$params) {
			if ($ufile = UFiles::fetchFileByModelAttribute($model, $name)) {
				$model->$name = $ufile;
			} else	{
				$model->$name = UFiles::getFileInstanceByModelAttribute($model, $name);
			}

			if ($model->$name && $model->$name->id() && !$model->isAttributeRequired($name)) {
				$model->$name->toDelete(!empty($_POST[get_class($model)][$name.'-delete']));
			}
		}
		return true;
	}

	public function afterValidate($event)
	{
		$model = $this->getOwner();
		if (!$model->hasErrors()) return;

		$update = array();
		foreach($this->getAttributes() as $name=>$params) {
			if (!$model->hasErrors($name)) {
				if ($model->$name instanceof  UFile) {
					if ($model->$name->moveToStorage()) {
						$update[$name] = $model->$name->id();
					}
				}
			}
		}
	}

	public function beforeSave($event)
	{
		// because of __toString
		$model = $this->getOwner();
		foreach($this->getAttributes() as $name=>$params) {
			$this->_savedValues[$name] = $model->$name;
			$model->$name = $model->$name->id();
		}
		// because of __toString

	}
	public function afterSave($event)
	{
		$model = $this->getOwner();
		foreach($this->getAttributes() as $name=>$params) 
		{
			// because of __toString
			$model->$name = $this->_savedValues[$name];
			unset($this->_savedValues[$name]);
			// because of __toString


			if (is_object($model->$name))
			{
				$ufile = &$model->$name;
				if ($ufile->isNew() || $ufile->toDelete()) {
					$this->manipulate($model, $name, $params);
					$update[$name] = $ufile->id();
				}
			}
		}
		if (!empty($update)) {
			$model->updateByPk($model->getPrimaryKey(), $update);
		}
	}
	//Создание изображения на основе параметров
	private function manipulate($model, $name, $params)
	{
		$ufile	  = $model->$name;
		$ofile	  = v::get($this->_originValues, $name);

		if ($ufile->isNew()) {
			$fileName = $this->getFileNameByModel($params['fileName'], $model, $name);
			$src	  = $ufile->move($fileName, false);
		}

		foreach($params['fileItems'] as $i=>$item) {
			if ($ofile && ($opath=UFiles::getFileInstance($ofile)->getPath($i))) {
				if (file_exists($opath)) unlink($opath);
			}
			if (!$ufile->toDelete()) {
				$this->manipulateFileItem($src, $ufile->getPath($i), $item);
			}
		}
		if(isset($src)) unlink($src);

		if ($ufile->toDelete()) {
			$ufile->move('', false);
		}
	}

	private function manipulateFileItem($src, $dst, $options)
	{
		$path = dirname($dst);
		if(!file_exists($path))
		{
			mkdir($path, 0777, true);
		}

		if (isset($options['fileHandler']))	{
			call_user_func($options['fileHandler'], $src, $dst, $options);
		} else {
			copy($src, $dst);
		}
	}


	public function afterDelete($event)
	{
		$model = $this->getOwner();
		foreach($this->getAttributes() as $name=>$params) {
			if (!is_object($model->$name)) continue;
			foreach($params['fileItems'] as $i=>$item) {
				$path = UFiles::getFileInstance($model->$name)->getPath($i);
				if (file_exists($path)) unlink($path);
			}
		}
	}

	private function getFileNameByModel($fileName, $model, $name)
	{
		if (!preg_match_all('#\{\w+\}|<\w+>#',$fileName, $matches)) return $fileName;
		$ufile = $model->$name;
		$replace = array();
		foreach($matches[0] as $m) {
			$param = substr($m,1,-1);
			if ($m[0]=='<') {
				$param = explode(':',$param,2);
				switch($param[0]) {
				case 'name':	$replace[$m] = UFiles::safeFileName(basename($ufile->getName(), strrchr($ufile->getName(),'.'))); break;
				case 'ext':		$replace[$m] = $ufile->getExt();  break;
				case 'date':	$replace[$m] = date(V::get($param,1,'ymd'));  break;
				case 'time':	$replace[$m] = date(V::get($param,1,'His'));  break;
				case 'rand':	$replace[$m] = mt_rand(1111,9999);  break;
				case 'ms':		$replace[$m] = ltrim(strrchr(microtime(true),'.'), '.');  break;
				}
			} else
			if ($m[0]=='{') {
				if (isset($model->$param)) {
					$replace[$m] = UFiles::safeFileName($model->$param);
				} else {
					if ($pref = strrchr($model->tableName(),'_')) {
						$pref = rtrim($pref,'_');
					} else {
						$pref = $model->tableName();
					}
					if (isset($model->{$pref.'_'.$param})) {
						$replace[$m] = UFiles::safeFileName($model->{$pref.'_'.$param});
					}
				}
			}
		}
		return strtr($fileName, $replace);
	}

	//Валидация опций создаваемого изображения
//	private function validateOptions($options){
//		if(!is_array($options))
//			throw new CHttpException(500,Yii::t('yiiext','Конфигурацией изображения должен быть массив'));
//		if(!isset($options['folder']))
//			throw new CHttpException(500,Yii::t('yiiext','Папка для загрузки не установлена'));
//		if(isset($options['resize']) && $options['resize']===false) return;
//		if(!isset($options['width']) || !isset($options['height']))
//			throw new CHttpException(500,Yii::t('yiiext','Параметры изображений установлены неправильно'));
//	}

}
