<?php
/**
 * Description of VkLikeWidget
 *
 * @author Slava Rudnev <slava.rudnev@gmail.com>
 */
class VkLikeWidget extends CWidget
{
	/**
	 * VKontakte API id
	 * @var integer
	 */
	public $apiId = 2450198;

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
		Yii::app()->clientScript
			->registerScriptFile('http://userapi.com/js/api/openapi.js', CClientScript::POS_HEAD)
			->registerScript('vkInit',
				"VK.init({apiId: {$this->apiId}});",
				CClientScript::POS_HEAD
			)
			->registerScript('vkLike',
				'VK.Widgets.Like("vk_like", {type: "10"});',
				CClientScript::POS_READY
			);

		echo '<div id="vk_like"></div>';
	}

	/**
	 * Rate counter
	 * @param string $url
	 */
//	public static function getRate($url,$apiId,$pass)
	public static function getRate($url)
	{
//		$vk = new Vkapi($apiId, $pass);
//		$resp = $vk->api('likes.getList', array(
//			'type'=>'sitepage',
//			'owner_id'=>2414760,
//			'page_url'=>$url,
//			'count'=>1,
//		));
//		return $resp['response']['count'];
		if (!($request = file_get_contents('http://vkontakte.ru/share.php?act=count&index=1&url='.$url)))
            return false;
        $tmp = array();
        if (!(preg_match('/^VK.Share.count\((\d+), (\d+)\);$/i',$request,$tmp)))
            return false;
        return $tmp[2];
	}
}