<div class="entry">

	<div class="entry-header">
		<?php echo CHtml::link($c->name, CController::createUrl('community/view', array('content_id' => $c->id)), array('class' => 'entry-title')); ?>
		<div class="user">
			<?php $this->widget('AvatarWidget', array('user' => $c->contentAuthor)); ?>
			<a class="username"><?php echo $c->contentAuthor->first_name; ?></a>
		</div>
	
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
				case 'article':
					$pos = strpos($c->article->text, '<!--more-->');
					echo $pos === false ? $c->article->text : substr($c->article->text, 0, $pos);
					break;
				case 'video':
					$video = new Video($c->video->link);
					echo '<div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div>';
					$pos = strpos($c->video->text, '<!--more-->');
					echo $pos === false ? $c->video->text : substr($c->article->video, 0, $pos);
					break;
			}
		?>
		<?php echo CHtml::link('редактировать', $this->createUrl('admin/community' . ucfirst($c->type->slug) . '/update', array('id' => $c->{$c->type->slug}->id))); ?>
		<?php echo CHtml::link('удалить', $this->createUrl('#', array('id' => $c->id)), array('submit'=>array('admin/communityContent/delete','id'=>$c->id),'confirm'=>'Вы уверены?')); ?>
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
		<a class="comm">Комментарии: <span><?php echo $c->commentsCount; ?></span></a>
		<div class="clear"></div>
	</div>
</div>