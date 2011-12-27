<?php
	$cs = Yii::app()->clientScript;

	$cs
		->registerCssFile('/stylesheets/wym.css');
?>

<?
	$this->breadcrumbs = array(
		'Сообщества' => array('community/index'),
		$community->name => array('community/list', 'community_id' => $community->id),
	);
	if (!is_null($rubric_id)) $this->breadcrumbs[$current_rubric->name] = array('community/list', 'community_id' => $community->id, 'rubric_id' => $current_rubric->id);
?>

<? $this->renderPartial('parts/left', array(
	'community' => $community,
	'content_type' => $content_type,
	'content_types' => $content_types,
	'current_rubric' => $rubric_id,
)); ?>

<div class="right-inner">

	<div>
		<?php
			$items = array();
			$items[] = array(
				'label' => 'Все',
				'url' => array('/community/list', 'community_id' => $community->id),
			);
			foreach ($content_types as $ct)
			{
				$params = array('community_id' => $community->id);
				if ($current_rubric !== null) $params['rubric_id'] = $current_rubric;
				if ($content_type != null) $params['content_type_slug'] = $content_type->slug;
				$items[] = array(
					'label' => $ct->name_plural,
					'url' => array('/community/list', 'community_id' => $community->id, 'content_type_slug' => $ct->slug),
					'active' => $content_type !== null AND $content_type->slug == $ct->slug,
					'linkOptions' => array(
						'rel' => 'nofollow',
					),
				);
			}
			
			$this->widget('zii.widgets.CMenu', array(
				'items' => $items,
			));
		?>
	</div>

	<? foreach($contents as $c): ?>
		<? $this->renderPartial('parts/list_entry', array('c' => $c)); ?>
	<? endforeach; ?>
	
	<?php if ($pages->pageCount > 1): ?>
		<div class="pagination pagination-center clearfix">
			<span class="text">
				Показано: <?php echo $pages->currentPage * $pages->pageSize + 1; ?>-<?php echo ($pages->currentPage + 1) * $pages->pageSize; ?> из <?php echo $pages->itemCount; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Страницы:
			</span>
			<?php $this->widget('LinkPager', array(
				'pages' => $pages,
			)); ?>
		</div>
	<?php endif; ?>

</div>