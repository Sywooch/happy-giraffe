<?php
/**
 * uFile class file.
 */

/**
 *
 */
class UFiles
{

	static $tmpRoot;
	static $httpRoot;
	static $webRoot;
	static $storageRoot;

	static	$params = array(
		'storageDir'=>'uploaded'	// related to webroot;
	);
	static $files;

	static function getFileInstanceByModelAttribute($model, $attribute)
	{
		return self::getFileInstance($model->$attribute);
	}
	static function getFileInstance($file)
	{
		if ($file instanceof UFile) return $file;
		return new uFile($file);
	}

	static function fetchFileByModelAttribute($model, $attribute)
	{
		return self::fetchFileByName(CHtml::resolveName($model, $attribute));
	}

	static function fetchFileByName($name)
	{
		if (!isset(self::$files)) self::prefetchFiles();

		return isset(self::$files[$name]) && self::$files[$name]->getError()!=UPLOAD_ERR_NO_FILE ? self::$files[$name] : null;
	}

	public static function getWebRoot()
	{
		if (!isset(self::$webRoot)) {
			self::$webRoot = self::tidyPath(Yii::getPathOfAlias('webroot'));
		}
		return self::$webRoot;
	}
	public static function getHttpRoot()
	{
		if (!isset(self::$httpRoot)) {
			$bu = Yii::app()->getBaseUrl();
			$wr = self::getWebRoot();
			self::$httpRoot = substr($wr, 0, strlen($wr)-strlen($bu));
		}
		return self::$httpRoot;
	}
	public static function getWebFileName($name)
	{
		return self::getWebRoot().'/'.$name;
	}

	public static function getStorageRoot()
	{
		if (!isset(self::$storageRoot)) {
			self::$storageRoot = rtrim(self::tidyPath(
				self::getWebFileName(v::get(Yii::app()->params,'ufileStorageRoot','uploaded'))
			),'/');
		}
		return self::$storageRoot;
	}
	public static function getStorageFileName($name)
	{
		return self::getStorageRoot().'/'.$name;
	}

	public static function getTmpRoot()
	{
		if (!isset(self::$tmpRoot)) {
			self::$tmpRoot = get_cfg_var('upload_tmp_dir');
			if (!self::$tmpRoot) {
				if (function_exists('sys_get_temp_dir')) {
					self::$tmpRoot = rtrim(self::tidyPath(sys_get_temp_dir()),'/');
				} else {
					self::$tmpRoot = '/tmp';
				}
			}
		}
		return self::$tmpRoot;
	}

	public static function getRelativePath($path)
	{
		$hrlen = strlen($httpRoot=self::getHttpRoot());
		if (strncasecmp($path, $httpRoot, $hrlen)==0) return substr($path, -hrlen);
		for($i=0, $plen=strlen($path); $i<$plen && $i<$hrlen && $path[$i]==$httpRoot[$i]; $i++);
		if (!$i) return false;
		$rootLeft = substr($httpRoot, $i);
		$rootLeft = preg_replace('#([^/]+)#','..',$rootLeft);
		return $rootLeft.'/'.substr($path, $i);
	}

	public static function getUrlByAbsolutePath($path)
	{
		$hrlen = strlen($httpRoot=self::getHttpRoot());
		if (strncasecmp($path, $httpRoot, $hrlen)!=0) return false;
		return substr($path, $hrlen);
	}

	public static function tidyPath($path)
	{
		$path = str_replace('\\','/',$path);
		$path = str_replace('/./','/',$path);
//		if (($p=strpos($path,':'))) $path=substr($path,$p+1);
		while(preg_match('#[^/]+/\.\./#',$path,$m,PREG_OFFSET_CAPTURE)) $path = substr_replace($path,'',$m[0][1],strlen($m[0][0]));
		return $path;
	}

	static function fileField($model, $attribute, $htmlOptions=array())
	{
		$ufile = self::getFileInstance($model->$attribute);

		$info ='';
		if ($url=$ufile->url) {
			$info .= CHtml::link($ufile->name, $url, array('target'=>'_blank'));
		} else
		if ($name=$ufile->name) {
			$info .= $name;
		}
		if ($ufile->id() && $ufile->isNew()!=1 && !$model->isAttributeRequired($attribute)) {
			if ($info && $ufile->toDelete()) {
				$info = '<span style="text-decoration: line-through;">'.$info.'</span>';
			}
			$info .= '&nbsp;'.CHtml::checkBox(get_class($model).'['.$attribute.'-delete]',$ufile->toDelete()).v::get($htmlOptions,'delete_title','delete');
		}

		$out = preg_replace(
			'#value=""#',
			'value="'.($ufile->isNew()==1 ?'' :CHtml::encode($ufile->id())).'"',
			CHtml::activeFileField($model,$attribute,$htmlOptions)
		);
		return $out.'&nbsp;'.$info;
	}

	public static function safeFileName($fileName, $unsafeChar='-', $toLower=false)
	{
		$converter = array(
			'а' => 'a',   'б' => 'b',   'в' => 'v',
			'г' => 'g',   'д' => 'd',   'е' => 'e',
			'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
			'и' => 'i',   'й' => 'y',   'к' => 'k',
			'л' => 'l',   'м' => 'm',   'н' => 'n',
			'о' => 'o',   'п' => 'p',   'р' => 'r',
			'с' => 's',   'т' => 't',   'у' => 'u',
			'ф' => 'f',   'х' => 'h',   'ц' => 'c',
			'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
			'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
			'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

			'А' => 'A',   'Б' => 'B',   'В' => 'V',
			'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
			'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
			'И' => 'I',   'Й' => 'Y',   'К' => 'K',
			'Л' => 'L',   'М' => 'M',   'Н' => 'N',
			'О' => 'O',   'П' => 'P',   'Р' => 'R',
			'С' => 'S',   'Т' => 'T',   'У' => 'U',
			'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
			'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
			'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
			'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		$str = strtr($fileName, $converter);
		$str = preg_replace('#[^A-Za-z0-9]+#u', $unsafeChar, $str);
		$str = preg_replace('#'.preg_quote($unsafeChar).'{2,}#u', $unsafeChar, $str);
		$str = trim($str, $unsafeChar);
		return $toLower ?strtolower($str) :$str;
	}

	/**
	 * Initially processes $_FILES superglobal for easier use.
	 * Only for internal usage.
	 */
	protected static function prefetchFiles()
	{
		self::$files = array();

		if(!isset($_FILES) || !is_array($_FILES)) return;

		foreach($_FILES as $class=>$info) {
			self::collectFilesRecursive($class, $info['name'], $info['tmp_name'], $info['type'], $info['size'], $info['error']);
		}
	}
	protected static function collectFilesRecursive($key, $names, $tmp_names, $types, $sizes, $errors)
	{
		if(is_array($names))
		{
			foreach($names as $item=>$name) {
				self::collectFilesRecursive($key.'['.$item.']', $names[$item], $tmp_names[$item], $types[$item], $sizes[$item], $errors[$item]);
			}
		} else {
			self::$files[$key] = self::getFileInstance(array(
				self::tidyPath($tmp_names), strtr($names,'<>{}','----'), $sizes, $types, $errors
			));
		}
	}
}

/**
 *
 */
class UFile extends CComponent
{
	private $_path;
	private $_name;
	private $_size;
	private $_type;
	private $_error;
	private $_delete;

	public function __construct($id)
	{
		if ($id) {
			if (is_string($id)) $id = explode('|', $id);
			@list($this->_path, $this->_name, $this->_size, $this->_type, $this->_error) = $id;
		}
	}

	function isNew()
	{
		$troot = UFiles::getTmpRoot();
		if (strncasecmp($this->_path, $troot, strlen($troot))==0) return 1;
		if (strpos($this->_path,':')==1 && strncasecmp(substr($this->_path,2), $troot, strlen($troot))==0) return 1;

		$troot = UFiles::getStorageRoot();
		if (strncasecmp($this->path, $troot, strlen($troot))==0) return 2;

		return 0;
	}

	function moveToStorage($basename=null)
	{
		if ($this->isNew()!=1) return false;

		if (!$basename) $basename = basename($this->_path, strrchr($this->_path,'.'));

		$filename = date('ymdhis',time()).'-'.trim(strrchr(microtime(true),'.'),'.');
		$filename.= '-'.$basename.'.'.$this->getExt();

		$res = copy($this->path, $storage = UFiles::getStorageFileName($filename));
		$url = UFiles::getUrlByAbsolutePath($storage);
		$this->_path = $url ?ltrim($url,'/') :$storage;

		return $res;
	}

	public function move($pathPattern, $copy=false)
	{
		$curPath = $this->getPath();
		$this->_path = $pathPattern;

		if ($copy) copy($curPath, $this->path);

		return $curPath;
	}

	public function toDelete($state=null)
	{
		if (isset($state)) {
			$this->_delete = $state;
		}
		return $this->_delete;
	}

	public function id()
	{
		return !strlen($this->_path) ?'' :$this->_path.'|'.$this->_name;
	}

	public function __toString()
	{
		return $this->id();
		throw new CHttpException(500,'__toString');
	}

	public function getName()
	{
		return $this->_name;
	}
	/**
	 * @return string the file extension name for {@link name}.
	 * The extension name does not include the dot character. An empty string
	 * is returned if {@link name} does not have an extension name.
	 */
	public function getExt()
	{
		return ltrim(strrchr($this->_name,'.'),'.');
	}

	public function getPath($item=null)
	{
		if (!strlen($this->_path)) return;

		if ($this->_path[0]!='/' && strpos($this->_path, ':')!=1) {
			$path = UFiles::getWebRoot().'/'.$this->_path;
		} else {
			$path = $this->_path;
		}
		return $item ?str_replace('*',$item,$path) :$path;
	}

	public function getUrl($item=null)
	{
		if (!$this->_path) return false;
		
		return UFiles::getUrlByAbsolutePath($this->getPath($item));
	}

	public function getType($item=null)
	{
		if (isset($item)) {
			return CFileHelper::getMimeType($this->getPath($item));
		}
		if (!isset($this->_type)) {
			$this->_type = CFileHelper::getMimeType($this->getPath());
		}
		return $this->_type;
	}

	/**
	 * @return integer the actual size of the uploaded file in bytes
	 */
	public function getSize($item=null)
	{
		if (isset($item)) {
			return filesize($this->getPath($item));
		}
		if (!isset($this->_size)) {
			$this->_size = filesize($this->getPath());
		}
		return $this->_size;
	}

	/**
	 * Returns an error code describing the status of this file uploading.
	 * @return integer the error code
	 * @see http://www.php.net/manual/en/features.file-upload.errors.php
	 */
	public function getError()
	{
		return $this->_error;
	}

	/**
	 * @return boolean whether there is an error with the uploaded file.
	 * Check {@link error} for detailed error code information.
	 */
	public function getHasError()
	{
		return $this->_error!=UPLOAD_ERR_OK;
	}

}

