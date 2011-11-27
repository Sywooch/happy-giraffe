<div class="section-banner" style="height: 297px;">
	<div class="section-nav" style="left:330px;top:40px;">
		<?php 
			$items = array();
			foreach ($content_types as $ct)
			{
				$items[] = array(
					'label' => '<span><span>' . $ct->name_plural . '</span></span></a>',
					'url' => array('/community/list', 'community_id' => $community->id, 'content_type_slug' => $ct->slug),
					'active' => $content_type->slug == $ct->slug,
					'linkOptions' => array(
						'class' => 'btn btn-blue-shadow',
					),
				);
			}
			
			$this->widget('zii.widgets.CMenu', array(
				'encodeLabel' => false,
				'items' => $items,
			));
		?>		
	</div>
	<img src="/images/community/<?php echo $community->id; ?>.jpg" />
</div>

<div class="left-inner">

	<div class="add">
		<a href="" class="btn btn-green-arrow-down"><span><span>Добавить</span></span></a>
		<ul class="leftadd">
			<? foreach ($content_types as $ct): ?>
				<?
					$add_params = array('content_type_slug' => $ct->slug, 'community_id' => $community->id);
					if (!is_null($current_rubric)) $add_params['rubric_id'] = $current_rubric;
					if (Yii::app()->user->isGuest)
					{
						$url = '#login';
						$htmlOptions = array('class' => 'fancy');
					}
					else
					{
						$url = CController::createUrl('community/add', $add_params);
						$htmlOptions = array();
					}
				?>
				<?=CHtml::tag('li', array(), CHtml::link($ct->name_accusative, $url, $htmlOptions))?>
			<? endforeach; ?>
		</ul>
	</div>

	<div class="themes">
		<div class="theme-pic">Рубрики</div>
		<ul class="leftlist">
			<? foreach ($community->rubrics as $r): ?>
					<?=CHtml::tag('li', array(), CHtml::link($r->name, CController::createUrl('/community/list', array('community_id' => $community->id, 'content_type_slug' => $content_type->slug, 'rubric_id' => $r->id)), $r->id == $current_rubric ? array('class' => 'current'):array()))?>
			<? endforeach; ?>
		
		</ul>


	</div>

	<div class="leftbanner">
		<a href=""><img src="/images/leftban.png"></a>
	</div>

</div>