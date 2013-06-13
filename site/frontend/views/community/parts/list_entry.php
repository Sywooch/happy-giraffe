<div class="entry">

	<div class="entry-header">
		<?php echo CHtml::link(CHtml::encode($c->title), CController::createUrl('community/view', array('community_id' => $c->rubric->community->id, 'content_type_slug' => $c->type->slug, 'content_id' => $c->id)), array('class' => 'entry-title')); ?>
		<?php if (! $c->by_happy_giraffe): ?>
			<div class="user">
				<?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $c->contentAuthor)); ?>
			</div>
		<?php endif; ?>
	
		<div class="meta">
			<div class="time"><?php echo Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", strtotime($c->created)); ?></div>
			<div class="seen">Просмотров:&nbsp <span id="page_views"><?php echo PageView::model()->viewsByPath(CController::createUrl('community/view', array('community_id' => $c->rubric->community->id, 'content_type_slug' => $c->type->slug, 'content_id' => $c->id)), true); ?></span></div>
			<div class="rate"><?php echo Rating::model()->countByEntity($c); ?></div>рейтинг
		</div>
		<div class="clear"></div>
	</div>

	<div class="entry-content wysiwyg-content">
		<?php
			switch ($c->type->slug)
			{
				case 'post':
                    if ($c->post === null)
                        $c->post = new CommunityPost();
					$pos = strpos($c->post->text, '<!--more-->');
					echo '<noindex>';
					echo $pos === false ? $c->post->text : substr($c->post->text, 0, $pos);
					echo '</noindex>';
					break;
				case 'video':
					$video = new Video($c->video->link);
					echo '<noindex><div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div></noindex>';
					echo $c->video->text;
					break;
			}
		?>
		<div class="clear"></div>
	</div>

	<div class="entry-footer">
		<?php if (($c->type->slug == 'post' AND in_array($c->post->source_type, array('book', 'internet'))) OR $c->by_happy_giraffe): ?>
			<div class="source">Источник:&nbsp;
				<?php if ($c->by_happy_giraffe): ?>
					Весёлый Жираф
				<?php else: ?>
					<?php switch($c->post->source_type):
					   case 'book': ?>
						<?php echo $c->post->book_author?>&nbsp;<?=$c->post->book_name; ?>
					<?php break; ?>
					<?php case 'internet': ?>
						<?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload/favicons/' . $c->post->internet_favicon, $c->post->internet_title); ?>&nbsp;<?php echo CHtml::link($c->post->internet_title, $c->post->internet_link, array('class' => 'link')); ?>
					<?php break; ?>
					<?php endswitch; ?>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<a class="comm">Комментарии: <span><?php echo $c->commentsCount; ?></span></a>
        <?php $this->renderPartial('admin_actions',array(
            'c'=>$c,
            'communities'=>Community::model()->findAll(),
        )); ?>
        <div class="clear"></div>
	</div>
    <?php $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
    $remove_tmpl->registerTemplates();
    $this->endWidget();
    ?>
</div>