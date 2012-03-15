<ul>
	<?php $i = 0; foreach ($comments as $cm): ?>
		<li class="clearfix<?php if(++$i % 2 == 1) echo ' even';?>">
			<div class="user">
				<?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $cm->author)); ?>
			</div>
			<div class="content">
				<div class="rating rating-<?php echo $cm->rating; ?>"></div>
				<?php echo $cm->text; ?>
				<div class="meta"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $cm->created); ?></div>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
<?php if (count($comments) > 3): ?><div class="all"><a href="">Ещё отзывы</a></div><?php endif; ?>