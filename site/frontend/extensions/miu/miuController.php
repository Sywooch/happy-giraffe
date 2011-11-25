<?php

/**
 * Description of miuController
 *
 * Config in main.php
 *
 * <code>
 * 'controllerMap' => array(
 *		'miu' => array(
 *           'class' => 'ext.miu.miuController',
 *           'folder' => 'uploads/temp',
 *           'mkdir' => true,
 *           'webPath' => '',
 *           'imagesRequired' => array(
 *              'thumb' => array('width' => 50, 'height' => 50, 'folder' => 'thumb'),
 *              'middle' => array('width' => 100, 'height' => 100, 'folder' => 'middle'),
 *              'big' => array('width' => 200, 'height' => 200, 'folder' => 'big'),
 *              'full' => array('width' => 400, 'height' => 400, 'folder' => 'full', 'smartResize' => false),
 *            ),
 *        ),
 *    ),
  * </code>
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */
class miuController extends Controller
{
	public $folder = 'uploads/temp';
	public $mkdir = true;
	public $webPath = '';
	public $imagesRequired = array(
		'thumb' => array('width' => 50, 'height' => 50, 'folder' => 'thumb'),
		'middle' => array('width' => 100, 'height' => 100, 'folder' => 'middle'),
		'big' => array('width' => 200, 'height' => 200, 'folder' => 'big'),
		'full' => array('width' => 400, 'height' => 400, 'folder' => 'full', 'smartResize' => false),
	);

	public function init()
	{
		if(isset($_POST['SESSION_ID']))
		{
			$session = Yii::app()->getSession();
			$session->close();
			$session->sessionID = $_POST['SESSION_ID'];
			$session->open();
		}
	}

	public function actionDelete()
	{
		if(!Yii::app()->user->hasState('miuFile'))
		{
			echo CJSON::encode(array(
				'error'=>Yii::t('yiiext', 'Delete error'),
			));
			Yii::app()->end();
		}
		$fileName = Yii::app()->user->getState('miuFile');

		$this->deleteImages($fileName);
	}

	//Удаление всех копий файла для текущей модели
	protected function deleteImages($fileName)
	{
		if(!is_array(reset($this->imagesRequired)))
			$this->deleteImage($this->imagesRequired['folder'], $fileName);
		else
			foreach($this->imagesRequired as $imageRequired)
				$this->deleteImage($imageRequired['folder'], $fileName);
	}

	protected function deleteImage($folder,$fileName)
	{
		$imagePath = $this->getAbsolutePath($folder, $fileName);
		if(file_exists($imagePath) && !is_dir($imagePath))
			unlink($imagePath);
	}

	public function actionUpload()
	{
		if(!Yii::app()->user->hasState('miuFile'))
		{
			echo CJSON::encode(array(
				'error'=>Yii::t('yiiext', 'Upload error'),
			));
			Yii::app()->end();
		}

		$fileName = Yii::app()->user->getState('miuFile');
		if(isset($_POST[$fileName]))
		{
			$file = CUploadedFile::getInstanceByName($fileName);

			$imageList = array();

			if(!is_array(reset($this->imagesRequired)))
			{
				$this->imagesRequired['fileName'] = $fileName;
				$imageList[] = $this->manipulate($file, $this->imagesRequired);
			} else
			{
				foreach($this->imagesRequired as $imageRequired)
				{
					$imageRequired['fileName'] = $fileName;
					$imageList[] = $this->manipulate($file, $imageRequired);
				}
			}

			echo CJSON::encode(array(
				'image'=>reset($imageList),
			));
			Yii::app()->end();
		}
	}

	private function manipulate($file, $options)
	{
		//Первым делом валидация
		$this->validateOptions($options);

		$targetFolder = $options['folder'];
		$fileName = $options['fileName'];

		//Путь будущего изображения
		$path = $this->getAbsolutePath($targetFolder, $fileName);

		if($this->mkdir && !file_exists(dirname($path)))
			mkdir(dirname($path), 0777, true);

		//Если изменять размеры не нужно - просто сделаем копию изображения
		if(isset($options['resize']) && !$options['resize'])
		{
			copy($file->getTempName(), $path);
			return $path;
		}

		//Ширина и высота требуемого изображения
		$targetWidth = $options['width'];
		$targetHeight = $options['height'];
		//Ширина и высота загруженного изображения
		list($uploadedWidth, $uploadedHeight) = getimagesize($file->getTempName());

		//Если изменять размеры не нужно - просто сделаем копию изображения
		if(isset($options['smartResize']) && !$options['smartResize'])
		{
			//Если требуемое изображение больше загруженного, его не нужно изменять
			if($targetWidth > $uploadedWidth && $targetHeight > $uploadedHeight)
			{
				copy($file->getTempName(), $path);
			} else
			{
				//Изображение для манипуляции берется из временной папки
				$image = Yii::app()->image->load($file->getTempName());

				//Манипуляция
				$image->resize($targetWidth, $targetHeight, Image::AUTO)->sharpen(1)->quality(95)->save($path);
			}
			return $path;
		}

		//Отношение сторон загруженного и требуемого изображения
		$uploadedRatio = $uploadedWidth / $uploadedHeight;
		$targetRatio = $targetWidth / $targetHeight;

		//Сравниваем отношения и считаем координаты для кадрирования(если нарисовать на бумаге алгоритм становится очевидным :))
		if($uploadedRatio > $targetRatio)
		{
			$cropHeight = $uploadedHeight;
			$cropWidth = $uploadedHeight * $targetRatio;
			$cropLeft = ($uploadedWidth - $uploadedHeight * $targetRatio) * 0.5;
			$cropTop = 0;
		} else
		{
			$cropHeight = $uploadedWidth / $targetRatio;
			$cropWidth = $uploadedWidth;
			$cropLeft = 0;
			$cropTop = ($uploadedHeight - $uploadedWidth / $targetRatio) * 0.2;
		}
		//Изображение для манипуляции берется из временной папки
		$image = Yii::app()->image->load($file->getTempName());
		//Манипуляция

		if(isset($options['crop']) && $options['crop'])
			$image->crop($cropWidth, $cropHeight, $cropTop, $cropLeft)
					->resize($targetWidth, $targetHeight, Image::NONE)
					->sharpen(1)->quality(95)->save($path);
		else
			$image->resize($targetWidth, $targetHeight, Image::AUTO)
					->sharpen(1)->quality(95)->save($path);

		return $path;
	}

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

	private function getAbsolutePath($folder, $fileName = null)
	{
		$path =
				Yii::app()->basePath . '/../' . //Путь к корню приложения
				$this->webPath .
				$this->folder . '/' .
				$folder . '/' . //Папка из конфигурации
				$fileName;
//		dump($path);
		return $path;
	}

}