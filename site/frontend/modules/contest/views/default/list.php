<?php
	$cs = Yii::app()->getClientScript();
	$js = "
$('#sort').change(function() {
	window.location.href = '" . $this->createAbsoluteUrl('/contest/list/' . $contest->contest_id) . "' + $(this).val() + '/';
});
	";
	$cs->registerScript('contest_list', $js);
?>

<div class="inner contest list">
	
<div class="photo-block">
        <div class="a-right fast-sort">
                Сортировать по:
                <?php echo CHtml::dropDownList('sort', $sort, array(
                    'created' => 'Дате',
                    'rate' => 'Рейтингу',
                ), array(
                    'id' => 'sort',
                    'class' => 'chzn'
                )); ?>
        </div>
		
		<div class="content-title">Участники конкурса</div>
		
		<div class="clear"></div>
		
		<ul class="photo-list">
			<?php foreach ($works as $w): ?>
				<li>
					<div class="img-box">							
						<?php echo CHtml::link(CHtml::image($w->photo->photo->getPreviewUrl(150, 150), $w->title), $this->createUrl('/contest/work/' . $w->id)); ?>
					</div>
					<div class="item-title"><?php echo $w->title; ?></div>
					<div class="mark">
						<span><?php echo $w->rate; ?></span> баллов
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
		
		<div class="clear"></div>
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
		<div class="clear"></div>
	</div>
	
	
	
</div>