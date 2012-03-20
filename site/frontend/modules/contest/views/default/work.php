<?php Yii::app()->clientScript->registerCssFile('/stylesheets/carusel.css'); ?>

<div class="inner contest">

	<div id="contest-photo">
		<div class="top">
			<div class="user-box clearfix">
				<?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $work->author)); ?>
			</div>
		</div>
		<div class="img-box">
			<div class="img-in"><?php echo CHtml::image($work->photo->photo->getPreviewUrl(600, 400), $work->title); ?></div>
			<div class="img-title"><?php echo $work->title; ?></div>
		</div>
	</div>

    <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
        'title' => 'Вам понравилось фото?',
        'model' => $work,
        'options' => array(
            'title' => $work->title,
            'image' => $work->photo->photo->getPreviewUrl(150, 150),
            'description' => false,
        ),
    )); ?>
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
		
	</div>
	
	<?php $this->widget('site.frontend.widgets.commentWidget.CommentWidget', array(
		'model' => $work,
	)); ?>
	
</div>