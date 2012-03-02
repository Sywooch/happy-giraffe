<?php
$criteria->addCondition('t.id = :id');
$criteria->params[':id'] = $data->id;
$c = CommunityContent::model()->find($criteria);
?>
<div class="entry">
	<div class="entry-header">
        <?php $name = Yii::app()->search->buildExcerpts(array($c->name), $search_index, $search_text); ?>
		<?php echo CHtml::link($name[0], CController::createUrl('community/view', array('community_id' => $c->rubric->community->id, 'content_type_slug' => $c->type->slug, 'content_id' => $c->id)), array('class' => 'entry-title')); ?>
		<?php if (! $c->by_happy_giraffe): ?>
			<div class="user">
				<?php $this->widget('AvatarWidget', array('user' => $c->contentAuthor)); ?>
				<a class="username"><?php echo $c->contentAuthor->first_name; ?></a>
			</div>
		<?php endif; ?>
	
		<div class="meta">
			<div class="time"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", strtotime($c->created)); ?></div>
			<div class="seen">Просмотров:&nbsp <span id="page_views"><?php echo PageView::model()->viewsByPath(CController::createUrl('community/view', array('community_id' => $c->rubric->community->id, 'content_type_slug' => $c->type->slug, 'content_id' => $c->id)), true); ?></span></div>
			<div class="rate"><?php echo Rating::model()->countByEntity($c); ?></div>рейтинг
		</div>
		<div class="clear"></div>
	</div>

	<div class="entry-content">
		<?php
			switch ($c->type->slug)
			{
				case 'post':
                    if ($c->post === null)
                        $c->post = new CommunityPost();
					$pos = strpos($c->post->text, '<!--more-->');
					$text = '<noindex>' . ($pos === false ? $c->post->text : substr($c->post->text, 0, $pos)) . '</noindex>';
					break;
				case 'travel':
					$pos = strpos($c->travel->text, '<!--more-->');
					$text = '<noindex>' . ($pos === false ? $c->travel->text : substr($c->travel->text, 0, $pos)) . '</noindex>';
					break;
				case 'video':
					$video = new Video($c->video->link);
					echo '<noindex><div style="text-align: center; margin-bottom: 10px;">' . $video->code . '</div></noindex>';
					$text = '<noindex>' . $c->video->text . '</noindex>';
					break;
			}
		?>
        <?php
        $text = Yii::app()->search->buildExcerpts(array($text), $search_index, $search_text);
        echo $text[0];
        ?>
        <?php if (Yii::app()->user->checkAccess('editCommunityContent', array('community_id'=>$c->rubric->community->id,'user_id'=>$c->contentAuthor->id))): ?>
        <?php echo CHtml::link('редактировать', ($c->type->slug == 'travel') ? $this->createUrl('community/editTravel', array('id' => $c->id)) : $this->createUrl('community/edit', array('content_id' => $c->id))); ?>
        <?php endif; ?>
        <?php if (Yii::app()->user->checkAccess('removeCommunityContent', array('community_id'=>$c->rubric->community->id,'user_id'=>$c->contentAuthor->id))): ?>
        <?php echo CHtml::link('удалить', $this->createUrl('#', array('id' => $c->id)), array('id' => 'CommunityContent_delete_' . $c->id, 'submit' => array('community/delete', 'id' => $c->id), 'confirm' => 'Вы точно хотите удалить тему?')); ?>
        <?php endif; ?>
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