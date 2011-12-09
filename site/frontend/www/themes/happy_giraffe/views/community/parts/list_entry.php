<div class="entry">

	<div class="entry-header">
		<?php echo CHtml::link($c->name, CController::createUrl('community/view', array('community_id' => $c->rubric->community->id, 'content_type_slug' => $c->type->slug, 'content_id' => $c->id)), array('class' => 'entry-title')); ?>
		<?php if (! $c->by_happy_giraffe): ?>
			<div class="user">
				<?php $this->widget('AvatarWidget', array('user' => $c->contentAuthor)); ?>
				<a class="username"><?php echo $c->contentAuthor->first_name; ?></a>
			</div>
		<?php endif; ?>
	
		<div class="meta">
			<div class="time"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", strtotime($c->created)); ?></div>
			<div class="seen">Просмотров:&nbsp <?php echo $c->views; ?></div>
			<div class="rate"><?php echo $c->rating; ?></div>рейтинг
		</div>
		<div class="clear"></div>
	</div>

	<div class="entry-content">
		<?php
			switch ($c->type->slug)
			{
				case 'post':
					$pos = strpos($c->post->text, '<!--more-->');
					echo $pos === false ? $c->post->text : substr($c->post->text, 0, $pos);
					break;
				case 'video':
					$video = new Video($c->video->link);
					echo '<div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div>';
					$pos = strpos($c->video->text, '<!--more-->');
					echo $pos === false ? $c->video->text : substr($c->post->video, 0, $pos);
					break;
			}
		?>
		<?php if ($c->contentAuthor->id == Yii::app()->user->id): ?>
			<?php echo CHtml::link('редактировать', $this->createUrl('community/edit', array('content_id' => $c->id))); ?>
			<?php echo CHtml::link('удалить', $this->createUrl('#', array('id' => $c->id)), array('submit'=>array('admin/communityContent/delete','id'=>$c->id),'confirm'=>'Вы уверены?')); ?>
		<?php endif; ?>
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
		<div class="clear"></div>
	</div>
</div>