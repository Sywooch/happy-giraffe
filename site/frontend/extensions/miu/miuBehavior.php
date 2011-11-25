<?php

/**
 * Description of miuBehavior
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */
class miuBehavior extends CActiveRecordBehavior
{

	public $fileAttribute;
	public $nameAttribute;
	public $folder = 'uploads';
	public $tempFolder = 'uploads/temp';
	public $mkdir = false;
	public $useDateForName = true;
	public $webPath = '';
	public $useUrlForName = false;
	public $imagesRequired;
	private $_oldFileName;
	private $_new = false;

	public function afterConstruct($event)
	{
		Yii::app()->user->setState('miuFile', md5(time()));
		return parent::afterConstruct($event);
	}

	public function afterFind($event)
	{
		Yii::app()->user->setState('miuFile', md5(time()));
		$this->_oldFileName = $this->getOwner()->{$this->fileAttribute};
		return parent::afterConstruct($event);
	}

	public function afterSave($event)
	{
		Yii::app()->user->setState('miuFile', null);
		return parent::afterSave($event);
	}

	public function beforeSave($event)
	{
		if(!$this->fileAttribute)
		{
			throw new CHttpException(500, Yii::t('yiiext', '"fileAttribute" должен быть установлен!'));
		}
		if(!$this->imagesRequired)
		{
			throw new CHttpException(500, Yii::t('yiiext', '"imagesRequired" должен(ны)быть установлен!'));
		}
		$this->validateOptions($options);

		$fExists = true;
		$fileName = Yii::app()->user->getState('miuFile');
		if(!is_array(reset($this->imagesRequired)))
		{
			$targetFolder = $this->imagesRequired['folder'];
			$fileName = $this->imagesRequired['fileName'];

			//Путь изображения
			$imagePath = $this->getAbsolutePath($targetFolder, $fileName, 'tempFolder');

			if(!file_exists($imagePath) || is_dir($imagePath))
				$fExists = false;
		} else
		{
			foreach($this->imagesRequired as $imageRequired)
			{
				$targetFolder = $imageRequired['folder'];
				$fileName = $imageRequired['fileName'];

				//Путь изображения
				$imagePath = $this->getAbsolutePath($targetFolder, $fileName, 'tempFolder');

				if(!file_exists($imagePath) || is_dir($imagePath))
					$fExists = false;
			}
		}

		$model = $this->getOwner();
		$fileAttribute = $this->fileAttribute;

		//Если файл не был загружен, поле с файлом обновлять не нужно.
		if($fExists)
		{
			$this->getOwner()->{$this->fileAttribute} = $this->_oldFileName;
			return;
		} elseif(!$model->isNewRecord && empty($model->$fileAttribute))
		{
			$this->deleteImages();
			return;
		}

		$fileInfo = getimagesize($fileName);

		$fileExtList = array(
			1=>'gif',
			2=>'jpg',
			3=>'png',
		);
		if(isset($fileExtList[$fileInfo[2]]))
			return;

		$fileExt = $fileExtList[$fileInfo[2]];
		//Имя будущего изображения
		if($this->nameAttribute)
		{
			$nameAttribute = $this->nameAttribute;
			$fileName = $this->safeFileName($model->$nameAttribute) . '.' . $fileExt;
		} else
		{
			$fileName = $this->safeFileName($fileName) . '.' . $fileExt;
		}
		if($this->useDateForName)
		{
			$fileName = date(is_string($this->useDateForName) ? $this->useDateForName : 'dMY_H-i-s') . $fileName;
		}

		Yii::import('ext.helpers.CArray');

		if(!is_array(reset($this->imagesRequired)))
		{
			$this->imagesRequired['fileName'] = $fileName;
			$this->manipulate($file, $this->imagesRequired);
		} else
		{
			foreach($this->imagesRequired as $imageRequired)
			{
				$imageRequired['fileName'] = $fileName;
				$this->manipulate($file, $imageRequired);
			}
		}

		$this->_new = true;

//		$model->$fileAttribute = $fileName;
		$model->$fileAttribute = $this->useUrlForName ? $this->getImageUrl(NULL, true) : $fileName;
	}

	//Абсолютный путь к изображеию
	private function getAbsolutePath($folder, $fileName = null, $folderAttribute='folder')
	{
		$path =
				Yii::app()->basePath . '/../' . //Путь к корню приложения
				$this->webPath .
				$this->$folderAttribute . '/' .
				$folder . '/' . //Папка из конфигурации
				$fileName;
//		dump($path);
		return $path;
	}

	//Получение ссылки на изображение
	public function getImageUrl($image = 'thumb', $abs = false)
	{
		$model = $this->getOwner();
		if($this->useUrlForName && !$this->_new)
			return $model->{$this->fileAttribute};

		if(!is_array(reset($this->imagesRequired)))
		{
			$folder = $this->imagesRequired['folder'];
		} else
		{
			if(!$image)
				return;
			$folder = $this->imagesRequired[$image]['folder'];
		}
		if($folder)
			$folder .= '/';

		$fileAttribute = $this->fileAttribute;
		$folder = '/' . $this->folder . '/' . $folder . $model->$fileAttribute;

		$fName = dirname(Yii::app()->basePath) . '/' . $this->webPath . $folder;

		if(!file_exists($fName) || !is_file($fName))
			$folder = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . '1pixelgif.gif');

		return $abs ? (Yii::app()->controller->createAbsoluteUrl('/') . $folder) : (Yii::app()->controller->createUrl('/') . $folder);
	}

	//Удаление всех копий файла для текущей модели
	public function deleteImages($folderAttribute='folder')
	{
		$fileAttribute = $this->fileAttribute;
		$model = $this->getOwner();

		if(!is_array(reset($this->imagesRequired)))
			$this->deleteImage($this->imagesRequired['folder'], $fileAttribute, $folderAttribute);
		else
			foreach($this->imagesRequired as $imageRequired)
				$this->deleteImage($imageRequired['folder'], $fileAttribute, $folderAttribute);
	}

	protected function deleteImage($folder, $fileName, $folderAttribute)
	{
		$imagePath = $this->getAbsolutePath($folder, $fileName, $folderAttribute);
		if(file_exists($imagePath) && !is_dir($imagePath))
			unlink($imagePath);
	}

	//Создание изображения на основе параметров
	private function manipulate($file, $options)
	{
		//Путь будущего изображения
		$path = $this->getAbsolutePath($targetFolder ,$fileName);

		//Путь изображения
		$pathEx = $this->getAbsolutePath($targetFolder, $fileName, 'tempFolder');

		if($this->mkdir && !file_exists(dirname($path)))
			mkdir(dirname($path), 0777, true);

		rename($pathEx, $path);
	}

	public function beforeDelete()
	{
		$this->deleteImages();
	}

	//Валидация опций создаваемого изображения
	private function validateOptions($options)
	{
		if(!is_array($options))
			throw new CHttpException(500, Yii::t('yiiext', 'Конфигурацией изображения должен быть массив'));
		if(!isset($options['folder']))
			throw new CHttpException(500, Yii::t('yiiext', 'Папка для загрузки не установлена'));
		if(isset($options['resize']) && $options['resize'] === false)
			return;
		if(!isset($options['width']) || !isset($options['height']))
			throw new CHttpException(500, Yii::t('yiiext', 'Параметры изображений установлены неправильно'));
	}

	//У файлов должны быть безопасные имена
	private function safeFileName($string)
	{
		$converter = array(
			'а' => 'a', 'б' => 'b', 'в' => 'v',
			'г' => 'g', 'д' => 'd', 'е' => 'e',
			'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
			'и' => 'i', 'й' => 'y', 'к' => 'k',
			'л' => 'l', 'м' => 'm', 'н' => 'n',
			'о' => 'o', 'п' => 'p', 'р' => 'r',
			'с' => 's', 'т' => 't', 'у' => 'u',
			'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
			'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
			'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
			'А' => 'A', 'Б' => 'B', 'В' => 'V',
			'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
			'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
			'И' => 'I', 'Й' => 'Y', 'К' => 'K',
			'Л' => 'L', 'М' => 'M', 'Н' => 'N',
			'О' => 'O', 'П' => 'P', 'Р' => 'R',
			'С' => 'S', 'Т' => 'T', 'У' => 'U',
			'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
			'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
			'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
		);
		$str = strtr($string, $converter);
		$str = strtolower($str);
		$str = preg_replace('~[^-a-z0-9_]+~u', '_', $str);
		$str = trim($str, "-");

		return $str;
	}

}
