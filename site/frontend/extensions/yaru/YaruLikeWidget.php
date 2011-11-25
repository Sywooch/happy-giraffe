<?php

/**
 * Description of YaruLikeWidget
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 *
 * <a counter="yes" type="button" size="small" share_text="dfgdfgdfg" name="ya-share"> </a><script charset="utf-8" type="text/javascript">if (window.Ya && window.Ya.Share) {Ya.Share.update();} else {(function(){if(!window.Ya) { window.Ya = {} };Ya.STATIC_BASE = 'http:\/\/img-css.friends.yandex.net\/';Ya.START_BASE = 'http:\/\/my.ya.ru\/';var shareScript = document.createElement("script");shareScript.type = "text/javascript";shareScript.async = "true";shareScript.charset = "utf-8";shareScript.src = Ya.STATIC_BASE + "/js/api/Share.js";(document.getElementsByTagName("head")[0] || document.body).appendChild(shareScript);})();}</script>
 *
 *
 */
class YaruLikeWidget extends CWidget
{
	/**
	 * Show counter?
	 * @var string yes/no
	 */
	public $counter = 'yes';

	/**
	 * Type of widget
	 * @var string button/icon
	 */
	public $type = 'button';

	/**
	 * Size of widget
	 * @var string large/small
	 */
	public $size = 'large';

	/**
	 * If Type is button you can use your text
	 * @var string
	 */
	public $share_text = '';

	public function run()
	{
		$config = array(
			'name'=>'ya-share',
			'counter'=>$this->counter,
			'type'=>$this->type,
			'size'=>$this->size,
		);
		if($this->type=='button' && $this->share_text!=' ')
			$config['share_text'] = $this->share_text;

		echo CHtml::link(' ', '#', $config);

		$js = "if (window.Ya && window.Ya.Share) {Ya.Share.update();} else {(function(){if(!window.Ya) { window.Ya = {} };Ya.STATIC_BASE = 'http:\/\/img-css.friends.yandex.net\/';Ya.START_BASE = 'http:\/\/my.ya.ru\/';var shareScript = document.createElement(\"script\");shareScript.type = \"text/javascript\";shareScript.async = \"true\";shareScript.charset = \"utf-8\";shareScript.src = Ya.STATIC_BASE + \"/js/api/Share.js\";(document.getElementsByTagName(\"head\")[0] || document.body).appendChild(shareScript);})();}";

		Y::script()->registerScript('yaruLike', $js, CClientScript::POS_END);
	}

	/**
	 * Rate counter
	 * @param string $url
	 */
	public static function getRate($url)
	{
		if (!($request = file_get_contents('http://wow.ya.ru/ajax/share-counter.xml?url='.$url)))
            return false;
        $tmp = array();
        if (!(preg_match("/(\s+)(\d+)(\s*)/i",$request,$tmp)))
            return false;
        return $tmp[2];
	}
}