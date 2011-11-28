<?php
	$cs = Yii::app()->clientScript;
	$ilike = "
function rate(count)
{
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {
			modelName: 'CommunityContent',
			objectId: " . $c->id . ",
			attributeName: 'rating',
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
	$js_content_report = "
$('.comments .item .report').live('click', function() {
	report($(this).parents('.item'));
	return false;
});
$('.spam a').live('click', function() {
	report($(this).parents('.entry'));
	return false;
});
";

	$cs
		->registerScript('content_report', $js_content_report)
		->registerScriptFile('http://vkontakte.ru/js/api/openapi.js', CClientScript::POS_HEAD)
		->registerScript('ilike', $ilike, CClientScript::POS_HEAD)
		->registerCssFile('/stylesheets/wym.css');
?>

<?php $this->breadcrumbs = array(
		'Сообщества' => array('community/index'),
		$c->rubric->community->name => array('community/list', 'community_id' => $c->rubric->community->id),
		$c->rubric->name => array('community/list', 'community_id' => $c->rubric->community->id, 'rubric_id' => $c->rubric->id),
		$c->name => array('community/view', 'content_id' => $c->id),
	); ?>

<?php $this->renderPartial('parts/left', array(
	'community' => $c->rubric->community,
	'content_type' => $c->type,
	'content_types' => $content_types,
	'current_rubric' => $c->rubric->id,
)); ?>

<div class="right-inner">
	<div class="entry entry-full" id="CommunityContent_<?php echo $c->id; ?>">

		<div class="entry-header">
			<h1><?php echo $c->name; ?></h1>
			<div class="user">
				<?php $this->widget('AvatarWidget', array('user' => $c->contentAuthor)); ?>
				<a class="username"><?php echo $c->contentAuthor->first_name; ?></a>
			</div>
		
			<div class="meta">
				<div class="time"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", strtotime($c->created)); ?></div>
				<div class="seen">Просмотров:&nbsp;<span><?php echo $c->views; ?></span></div>
				
			</div>
			<div class="clear"></div>
		</div>
	
		<div class="entry-content">
			<?
				switch ($c->type->slug)
				{
					case 'article':
						echo $c->article->text;
						break;
					case 'video':
						$video = new Video($c->video->link);
						echo '<div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div>';
						echo $c->video->text;
						break;
				}
			?>
			<?php echo CHtml::link('редактировать', $this->createUrl('admin/community' . ucfirst($c->type->slug) . '/update', array('id' => $c->{$c->type->slug}->id))); ?>
                        <?php echo CHtml::link('удалить', $this->createUrl('#', array('id' => $c->id)), array('id' => 'CommunityContent_delete_' . $c->id, 'submit'=>array('admin/communityContent/delete','id'=>$c->id),'confirm'=>'Вы уверены?')); ?>
			<div class="clear"></div>
		</div>
	
		<div class="entry-footer">
			<?php if ($c->type->slug == 'article'): ?>
				<div class="source">Источник:&nbsp;
					<? switch($c->article->source_type):
					   case 'me': ?>
						<?=$c->contentAuthor->first_name?>
					<? break; ?>
					<? case 'book': ?>
						<?=$c->article->book_author?>&nbsp;<?=$c->article->book_name?>
					<? break; ?>
					<? case 'internet': ?>
						<?=CHtml::image(Yii::app()->request->baseUrl . '/upload/favicons/' . $c->article->internet_favicon, $c->article->internet_title)?>&nbsp;<?=CHtml::link($c->article->internet_title, $c->article->internet_link, array('class' => 'link'))?>
					<? break; ?>
					<? endswitch; ?>
				</div>
			<?php endif; ?>
			<span class="comm">Комментариев: <span><?php echo $c->commentsCount; ?></span></span>
			<div class="spam">
				<a href="#"><span>Нарушение!</span></a>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div class="like-block">
		<div class="block">
			<div class="rate"><?php echo $c->rating; ?></div>
			рейтинг
		</div>
		<big>Вам <?php switch($c->type->slug) {case 'article': echo 'понравилась статья'; break; case 'video': echo 'понравилось видео'; break;} ?>? Отметьте!</big>
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
	
	<?php if ($related): ?>
		<div class="more">
			<big class="title">
				Ещё <?php echo mb_strtolower($c->type->name_plural, "UTF-8"); ?> на эту тему
				<a href="<?php echo $this->createUrl('community/list', array('community_id' => $c->rubric->community->id, 'rubric_id' => $c->rubric->id)); ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
			</big>
			<?php 
				foreach ($related as $rc)
				{
					echo $rc->id;
					break;
					switch ($rc->type->slug)
					{
						case 'article':
							if (preg_match('/src="([^"]+)"/', $rc->article->text, $matches))
							{
								$content = '<img src="' . $matches[1] . '" alt="' . $rc->name . '" width="150" />';
							}
							else
							{
								preg_match('/<p>(.+)<\/p>/', $rc->article->text, $matches2);
								$content = strip_tags($matches2[1]);
							}
						break;
						case 'video':
							$video = new Video($rc->video->link);
							$content = '<img src="' . $video->preview . '" alt="' . $video->title . '" />';
						break;
					}
				
			?>
			<div class="block">
				<b><?php echo CHtml::link($rc->name, $this->createUrl('community/view', array('content_id' => $rc->id))); ?></b>
				<p><?php echo $content; ?></p>
			</div>
			<?php
				}
			?>
			<div class="clear"></div>
		</div>
	<?php endif; ?>
	
	<?php $this->widget('CommentWidget', array(
		'model' => 'CommunityContent',
		'object_id' => $c->id,
	)); ?>
</div>