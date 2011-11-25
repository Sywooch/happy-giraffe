<?php

/**
 * Description of LikeWidget
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */
class OkLikeWidget extends CWidget
{
	/**
	 * URL. Used when needed for some else page
	 * @var string
	 */
	public $url = '';

	/**
	 * main function
	 */
	public function run()
	{
		$cs = Yii::app()->clientScript;
		$cs
			->registerScriptFile('http://stg.odnoklassniki.ru/share/odkl_share.js')
			->registerCssFile('http://stg.odnoklassniki.ru/share/odkl_share.css')
			->registerScript('okinit','ODKL.init();',CClientScript::POS_LOAD);

		echo CHtml::link('<span>0</span>',Yii::app()->request->url,array(
			'class'=>'odkl-klass-stat',
			'onclick'=>'js:ODKL.Share(this);return false;'
		));
	}


	/**
	 * Rate counter
	 * @param string $url
	 */
	public static function getRate($url)
	{
		$text = file_get_contents('http://www.odnoklassniki.ru/dk?st.cmd=extOneClickLike&uid=odklock0&ref='.urlencode(rtrim($url,'/')));
		$text = explode("'", $text);
		return intval($text[3]);
	}
}

