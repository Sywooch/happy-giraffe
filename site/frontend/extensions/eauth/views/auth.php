  <?php
	switch ($this->mode)
	{
		case 'signup':
			foreach ($services as $service) {
				echo '<li>';
				echo CHtml::link(CHtml::image('/images/btn_social_' . $service->id . '.png'), array($action, 'service' => $service->id), array(
					'class' => 'auth-service ' . $service->id,
				));
				echo '</li>';
			}
			break;
		case 'login':
			foreach ($services as $service) {
				echo CHtml::link(CHtml::image('/images/icon_social_' . $service->id . '.png'), array($action, 'service' => $service->id), array(
					'class' => 'auth-service ' . $service->id,
				));
			}
			break;
	}
  ?>

  <?php
    $cs = Yii::app()->clientScript;
	$cs->registerCoreScript('jquery');
	
	$url = Yii::app()->assetManager->publish($assets_path, false, -1, YII_DEBUG);
	$cs->registerCssFile($url.'/css/auth.css');

	// Open the authorization dilalog in popup window.
	if ($popup) {
		$cs->registerScriptFile($url.'/js/auth.js', CClientScript::POS_HEAD);
		$js = '';
		foreach ($services as $service) {
			$args = $service->jsArguments;
			$args['id'] = $service->id;
			$js .= '$("a.auth-service.'.$service->id.'").eauth('.json_encode($args).');'."\n";
		}
		$cs->registerScript('eauth-services', $js, CClientScript::POS_READY);
	}
  ?>