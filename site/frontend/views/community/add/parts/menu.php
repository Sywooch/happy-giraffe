<? foreach ($content_types as $cs): ?>
	<? if ($cs->slug == $content_type->slug): ?>
		<span class="current"><?=$cs->title_accusative?></span>
	<? else: ?>
		<?
			$add_params = array('content_type_slug' => $cs->slug);
			if (!is_null($community_id)) $add_params['community_id'] = $community_id;
			if (!is_null($rubric_id)) $add_params['rubric_id'] = $rubric_id;
		?>
		<span><?=CHtml::link($cs->title_accusative, CController::createUrl('community/add', $add_params))?></span>
	<? endif; ?>
<? endforeach; ?>