<?php

/**
 * Description of html5UploaderWidget
 *
 * @author Вячеслав
 * 
 * @see http://www.igloolab.com/jquery-html5-uploader
 * 
 * Sample:
 * <code>
 * <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.html5uploader.min.js"></script>
<script type="text/javascript">
$(function() {
	$("#dropbox, #multiple").html5Uploader({
		name: "foo",
		postUrl: "bar.aspx"	
	});
});
</script>
<div id="dropbox"></div>
<input id="multiple" type="file" multiple>
 * </code>
 */
class html5UploaderWidget extends CInputWidget
{
	public $postUrl = '/';
	
	public $text = '&nbsp;';


	/**
	 *
	 * @var array
	 * 
	 * <code>
	 * Settings

    name: upload field identifier.
    postUrl: the url to post the file data.
    onClientAbort: Called when the read operation is aborted.
    onClientError: Called when an error occurs.
    onClientLoad: Called when the read operation is successfully completed.
    onClientLoadEnd: Called when the read is completed, whether successful or not. This is called after either onload or onerror.
    onClientLoadStart: Called when reading the data is about to begin.
    onClientProgress: Called periodically while the data is being read.
    onServerAbort: Called when the post operation is aborted.
    onServerError: Called when an error occurs.
    onServerLoad: Called when the post operation is successfully completed.
    onServerLoadStart: Called when posting the data is about to begin.
    onServerProgress: Called periodically while the data is being posted.
    onServerReadyStateChange: A JavaScript function object that is called whenever the readyState attribute changes. The callback is called from the user interface thread.
	 * </code> 
	 */
	public $options = array();


	private $baseUrl;

	public function init()
	{
		$this->publishAssets();
		$this->registerClientScripts();
		
		return parent::init();
	}
	
	public function run()
	{
		$cs = Yii::app()->getClientScript();
        $cs = Y::script();
		
		list($name,$id) = $this->resolveNameID();
		
		$htmlOptions = array_merge(array(
			'id'=>$id,
		),$this->htmlOptions);
		
		
		echo CHtml::tag('div', $htmlOptions, $this->text, true);
		
		$js = $this->createJsCode();
        $cs->registerScript('html5Uploader_'.$this->getId(), $js);
	}
	
	public function createJsCode()
	{
		list($name,$id) = $this->resolveNameID();
		
		if(is_array($this->postUrl))
		{
			$url = reset($this->postUrl);
			unset($this->postUrl[0]);
		}
		
		$options = array_merge($this->options,array(
			'name'=>$name,
			'postUrl'=>$this->getController()->createUrl($url, $this->postUrl),
		));
		
		$options = CJavaScript::encode($options);
		
		return "$('#$id').html5Uploader($options);";
	}


	public function publishAssets()
    {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'source';
        $this->baseUrl = Yii::app()->getAssetManager()->publish($dir);
    }
	
	public function registerClientScripts()
    {
        // add the script
        $cs = Yii::app()->getClientScript();

        $cs->registerCoreScript('jquery');
		$cs->registerScriptFile($this->baseUrl.'/jquery.html5uploader.min.js');
    }
}
