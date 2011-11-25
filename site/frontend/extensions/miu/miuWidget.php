<?php

/**
 * Description of miuWidget
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */
class miuWidget extends CInputWidget
{
	public $sessionKey = 'SESSION_ID';
	public $uploadButton;
	public $uploadButtonOptions = array();
	public $uploadButtonTagname = 'a';
	public $uploadButtonText = 'Upload Files';

	private $_options = array();
	private $_name;
	private $_id;
	private $_basePath;

	public function run()
	{
		if($this->hasModel())
		{
			if($this->model->{$this->attribute})
			{
				
			}
		}

	}

	private function uploadify()
	{
		$uploadConfigFields = array(
			'sessionKey',
			'buttonText',
			'script',
			'checkScript',
			'fileExt',
			'fileDesc',
			'uploadButton',
			'uploadButtonText',
			'uploadButtonTagname',
			'uploadButtonOptions',

			'model','attribute','name','value','htmlOptions',
		);

		$uploadConfig = array();
		foreach($uploadConfigFields as $field)
			if($this->$field)
				$uploadConfig[$field] = $this->$field;

		$this->widget('ext.uplofify.MUploadify', $uploadConfig);
	}

}