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

	<? foreach($contents as $c): ?>
		<? $this->renderPartial('parts/list_entry', array('content_type' => $content_type, 'c' => $c)); ?>
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

<?php $this->widget('LinkPager', array(
	'pages' => $pages,
)); ?>