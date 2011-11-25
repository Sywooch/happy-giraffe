<?php

class UFileValidator extends CValidator
{

	public $allowEmpty=false;
	public $minSize;
	public $maxSize;
	public $minWidth;
	public $maxWidth;
	public $minHeight;
	public $maxHeight;
	/**
	 *	array of('ext'|'/regexp/'=>mime-type | true | false)
	 *	string: 'ext, ext, ext, ...'
	 *
	 *  http://www.sfsu.edu/training/mimetype.htm
	 */
	public $allowedTypes = array();

	protected $mimeTypes = array(
		'jpg'=>'image/jpeg',
		'png'=>'image/png',
		'gif'=>'image/gif',
		'zip'=>'application/zip',
		'pdf'=>'application/pdf',
		'txt'=>true,
		'exe'=>false,
		'/^php\d?|cgi|phtml$/'=>false
	  );

	public $notFoundMsg;
	public $sizeTooLargeMsg;
	public $sizeTooSmallMsg;
	public $widthTooLargeMsg;
	public $widthTooSmallMsg;
	public $heightTooLargeMsg;
	public $heightTooSmallMsg;
	public $wrongTypeMsg;

	protected $imagesizes;
	  
	protected function validateAttribute($object, $attribute)
	{
		$ufile = $object->$attribute;
		$this->validateFile($object, $attribute, $ufile);
	}
	
	protected function validateFile($object, $attribute, $ufile)
	{
		if(!$ufile->id()) {
			return $this->emptyAttribute($object, $attribute);
		}
		if (!$ufile->isNew()) return;

		if (!file_exists($filePath=$ufile->getPath())) {
			$message = isset($this->notFoundMsg) ?$this->notFoundMsg :Yii::t('yii','File "{file}" was not found.');
			return $this->addError($object,$attribute,$message,array('{file}'=>$ufile->getName()));
		}
		if ($message=$this->checkFileType($ufile, $this->allowedTypes)) {
			return $this->addError($object,$attribute,$message);

		}

		if(isset($this->maxSize) && $ufile->getSize()>$this->maxSize) {
			$message = isset($this->sizeTooLargeMsg) ?$this->sizeTooLargeMsg :Yii::t('yii','The file "{file}" is too large. Its size cannot exceed {limit} bytes.');
			$this->addError($object,$attribute,$message,array('{file}'=>$ufile->getName(), '{limit}'=>$this->maxSize));
		}

		if(isset($this->minSize) && $ufile->getSize()<$this->minSize) {
			$message = isset($this->sizeTooSmallMsg) ?$this->sizeTooSmallMsg :Yii::t('yii','The file "{file}" is too small. Its size cannot be smaller than {limit} bytes.');
			$this->addError($object,$attribute,$message,array('{file}'=>$ufile->getName(), '{limit}'=>$this->minSize));
		}

		if (isset($this->maxWidth) && $this->getImageSize($filePath, 0)>$this->maxWidth)
		{
			$message = isset($this->widthTooLargeMsg) ?$this->widthTooLargeMsg :Yii::t('yii','Invalid file width for "{file}". It can\'t be greater then {limit} px.');
			$this->addError($object,$attribute,$message,array('{file}'=>$ufile->getName(), '{limit}'=>$this->maxWidth));
		}

		if (isset($this->maxHeight) && $this->getImageSize($filePath, 1)>$this->maxHeight)
		{
			$message = isset($this->heightTooLargeMsg) ?$this->heightTooLargeMsg :Yii::t('yii','Invalid file height for "{file}". It can\'t be greater then {limit} px.');
			$this->addError($object,$attribute,$message,array('{file}'=>$ufile->getName(), '{limit}'=>$this->maxHeight));
		}

		if (isset($this->minWidth) && $this->getImageSize($filePath, 0)<$this->minWidth)
		{
			$message = isset($this->widthTooSmallMsg) ?$this->widthTooSmallMsg :Yii::t('yii','Invalid file width for "{file}". It can\'t be less then {limit} px.');
			$this->addError($object,$attribute,$message,array('{file}'=>$ufile->getName(), '{limit}'=>$this->minWidth));
		}

		if (isset($this->minHeight) && $this->getImageSize($filePath, 1)<$this->minHeight)
		{
			$message = isset($this->heightTooSmallMsg) ?$this->heightTooSmallMsg :Yii::t('yii','Invalid file height for "{file}". It can\'t be less then {limit} px.');
			$this->addError($object,$attribute,$message,array('{file}'=>$ufile->getName(), '{limit}'=>$this->minHeight));
		}
	}
	protected function checkFileType($ufile, $types)
	{
		if(is_string($types)) {
			$types = preg_split('/[\s,]+/',strtolower($types),-1,PREG_SPLIT_NO_EMPTY);
		}
		$ext = strtolower($ufile->getExt());
		$ok  = false;
		foreach($types as $t=>$mime) {
			if (is_int($t)) { 
				$t = preg_split('/[\s,]+/',strtolower($mime),-1,PREG_SPLIT_NO_EMPTY);
				if (!in_array($ext, $t)) continue;

				$mime = true;
				foreach($this->mimeTypes as $e=>$m) {
					if ($e[0]=='/' ?preg_match($e, $ext) :$e==$ext) {
						$mime = $m;
						break;
					}
				}
			} else {
				if ($t!=$ext) continue;
			}

			if (is_bool($mime)) {
				if($mime) $ok = true;
			} else {
				$mtype = CFileHelper::getMimeType($filePath=$ufile->getPath(), null, false);
				if (!isset($mtype)) {
					$mtype = $this->getImageSize($filePath,'mime');
				}
				$ok = empty($mtype) && strncmp($mime,'image',5) || $mime==$mtype;
			}
			break;
		}
		if (!$ok) {
			$message = isset($this->wrongTypeMsg) ?$this->wrongTypeMsg :Yii::t('yii','The file "{file}" cannot be uploaded. Invalid file type "{mime}".');
			return strtr($message, array('{file}'=>$ufile->getName(), '{mime}'=>!empty($mtype) ?$mtype :$ext));
		}
		return '';
	}

	protected function getImageSize($fileName, $id=null)
	{
		if (!isset($this->imagesizes[$fileName])) {
			$this->imagesizes[$fileName] = @getimagesize($fileName);
		}
		return isset($id) && $this->imagesizes[$fileName] ?v::get($this->imagesizes[$fileName], $id) :$this->imagesizes[$fileName];
	}
	

	protected function emptyAttribute($object, $attribute)
	{
		if(!$this->allowEmpty)
		{
			$message = isset($this->message) ?$this->message :Yii::t('yii','{attribute} cannot be blank.');
			$this->addError($object,$attribute,$message);
		}
	}

}
?>