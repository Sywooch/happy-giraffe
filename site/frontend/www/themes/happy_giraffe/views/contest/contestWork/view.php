<?php
	$cs = Yii::app()->getClientScript();
	$ilike = "
function rate(count)
{
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {
			modelName: 'ContestWork',
			objectId: " . $work->work_id . ",
			attributeName: 'work_rate',
			r: count,
		},
		url: '" . CController::createUrl('/ajax/rate') . "',
		success: function(response) {
			$('div.rate').text(response);
		}
	});
}
VK.init({
	apiId: 2450198, 
	onlyWidgets: true
});
VK.Observer.subscribe('widgets.like.liked', function(count){
	rate(count);
});
VK.Observer.subscribe('widgets.like.unliked', function(count){
	rate(count);
});
	";
	$js_work_report = "
$('.comments .item .report').live('click', function() {
	report($(this).parents('.item'));
	return false;
});
";
	$cs->registerScript('work_report', $js_work_report)->registerCssFile('/stylesheets/carusel.css')->registerScriptFile('http://vkontakte.ru/js/api/openapi.js', CClientScript::POS_HEAD)->registerScript('ilike', $ilike, CClientScript::POS_HEAD);
?>

<?php $this->breadcrumbs = array(
		'Конкурсы' => array('/contest'),
		$work->contest->contest_title => array('/contest/view', 'id' => $work->contest->contest_id),
		$work->work_title => array('/contestWork/view', 'id' => $work->work_id),
	); ?>

<div class="inner contest">

	<div id="contest-photo">
		<div class="top">
			<div class="user-box clearfix">
				<?php $this->widget('AvatarWidget', array('user' => $work->author)); ?>
				<?php echo $work->author->first_name; ?>
			</div>
		</div>
		<div class="img-box">
			<div class="img-in"><?php echo CHtml::image($work->work_image->getUrl('big'), $work->work_title); ?></div>
			<div class="img-title"><?php echo $work->work_title; ?></div>
		</div>
	</div>

	<div class="like-block">
		<div class="block">
			<div class="rate"><?php echo $work->work_rate; ?></div>
			рейтинг
		</div>
		<big>Тебе нравится? Проголосуй!</big>
		<div class="like">
			<span style="width:150px;">
				<div id="vk_like" style="height: 22px; width: 180px; position: relative; clear: both; background-image: none; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: initial; background-position: initial initial; background-repeat: initial initial; "></div>
					<script type="text/javascript">
					VK.Widgets.Like("vk_like", {type: "button"});
				</script>
			</span>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<br/>
	<div class="photo-block">
		<big class="title">
			Другие участники конкурса
			<a href="<?php echo $this->createUrl('/contest/list/' . $work->contest->contest_id); ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
		</big>
		<ul class="photo-list">
			<?php foreach ($others as $w): ?>
				<li>
					<div class="img-box">							
						<?php echo CHtml::link(CHtml::image($w->work_image->getUrl('thumb'), $w->work_title), $this->createUrl('/contest/work/' . $w->work_id)); ?>
					</div>
					<div class="item-title"><?php echo $w->work_title; ?></div>
					<div class="mark">
						<span><?php echo $w->work_rate; ?></span> баллов
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
						
		<div class="clear"></div>
		
	</div>
	
	<?php $this->widget('CommentWidget', array(
		'model' => 'ContestWork',
		'object_id' => $work->work_id,
	)); ?>
	
</div>