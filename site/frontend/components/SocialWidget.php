<?php

class SocialWidget extends CWidget
{	
	public function run()
	{
		Yii::app()->clientScript
			->registerScript('vkAuth',
				"VK.Widgets.Auth('vk_auth', {width: '300px', authUrl: '/club/social/vk'});",
				CClientScript::POS_READY
			);

		echo '<div id="vk_auth"></div>';
		
		$api_id = Yii::app()->params['social']['mail']['api_id'];
		$secret_key = Yii::app()->params['social']['mail']['secret_key'];
		Yii::app()->clientScript
			->registerScript('mailAuth',
				"mailru.loader.require('api', function() {
				
					mailru.connect.init('$api_id', '$secret_key' );
					mailru.events.listen(mailru.connect.events.login, function(session){
			$.get(
				'/club/social/mail',
				function (data)
				{
					location.reload();
				}
			);
					});
					mailru.events.listen(mailru.connect.events.logout, function(){
						window.location.reload();
					});
					mailru.connect.getLoginStatus(function(result) {
						if (result.is_app_user != 1) {
							mailru.connect.initButton();
						} else {
							mailru.common.users.getInfo(function(result){console.log(result[0].uid)});

						}
					});
				});",
				CClientScript::POS_END
			);
			
		echo '<a class="mrc__connectButton">вход@mail.ru</a>';
	}
}


