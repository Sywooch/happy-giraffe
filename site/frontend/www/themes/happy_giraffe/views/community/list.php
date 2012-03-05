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
                if ($ct->id == 3 && $community->id != 21) break;
				$params = array('community_id' => $community->id);
				if ($current_rubric !== null)
				{
					$params['rubric_id'] = $current_rubric;
					$label = (Yii::app()->user->checkAccess('moderator')) ? $ct->name_plural . ' (' . $current_rubric->getCount($ct->id) . ')'  : $ct->name_plural;
				}
				else
				{
					$label = (Yii::app()->user->checkAccess('moderator')) ? $ct->name_plural . ' (' . $community->getCount($ct->id) . ')'  : $ct->name_plural;
				}
				if ($content_type != null) $params['content_type_slug'] = $content_type->slug;
				$items[] = array(
					'label' => $label,
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
<?php if (!empty($contents))
    $this->renderPartial('parts/move_post_popup',array('c'=>$contents[0])); ?>
<?php Yii::app()->clientScript->registerScript('register_after_removeContent','
function CommunityContentRemove() {window.location.reload();}', CClientScript::POS_HEAD); ?>

<!--
Отработало за <?=sprintf('%0.5f',Yii::getLogger()->getExecutionTime())?> с.
Скушано памяти: <?=round(memory_get_peak_usage()/(1024*1024),2)."MB"?>
-->