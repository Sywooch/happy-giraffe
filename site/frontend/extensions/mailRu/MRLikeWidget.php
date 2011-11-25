<?php

/**
 * Mail.ru Like button
 *
 * <code>
 * <a target="_blank" class="mrc__plugin_like_button" href="http://connect.mail.ru/share?share_url=http%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Freference%2Fjavascript%2F" data-mrc-config="{'type' : 'button', 'width' : '550', 'show_text' : 'true', 'show_faces' : 'true'}">Нравится</a>
<script src="http://cdn.connect.mail.ru/js/loader.js" type="text/javascript" charset="UTF-8"></script>
 * </code>
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */

class MRLikeWidget extends CWidget
{
	/**
	 * Config array
	 * @var array
	 * 'type' can be 'button' or 'micro'
	 */
	public $config = array(
			'type'=>'button',
			'width'=>150,
			'show_text'=>false,
			'show_faces'=>false,
		);

	/**
	 * URL. Used when needed for some else page
	 * @var string
	 */
	public $url = '';

	/**
	 * Preview image
	 * @var string
	 */
	public $image_src = '';

	/**
	 * main function
	 */
	public function run()
	{
		$url  = 'http://connect.mail.ru/share';
		$url .= $this->url
			? ('?share_url='.htmlentities(urlencode($this->url)))
			: '';

		$config = array();
		foreach($this->config as $k=>$v)
			if($v)
				$config[] = "'$k': '$v'";

		$config_str = '';
		if($config)
			$config_str = "{".implode(', ', $config)."}";

		echo CHtml::link('Нравится', $url, array(
			'encode'=>false,
			'target'=>'_blank',
			'class'=>'mrc__plugin_like_button',
			'data-mrc-config'=>$config_str,
		));

		if($this->image_src)
			Yii::app()->clientScript->registerLinkTag('image_src',null,$this->image_src);

		Yii::app()->clientScript->registerScriptFile('http://cdn.connect.mail.ru/js/loader.js',  CClientScript::POS_END);
	}

	/**
	 * Rate counter
	 * @param string $url
	 */
	public static function getRate($url)
	{
		$ch = curl_init();
		$text = file_get_contents('http://connect.mail.ru/share_count?url_list='.$url);
		$array = CJSON::decode($text, true);
		return intval($array[$url]['shares']);
	}
}