<?php Yii::app()->clientScript->registerCssFile('/stylesheets/carusel.css'); ?>

<?php $this->breadcrumbs = array(
		'Конкурсы' => array('/contest'),
		$work->contest->contest_title => array('/contest/view', 'id' => $work->contest->contest_id),
		$work->work_title => array('/contestWork/view', 'id' => $work->work_id),
	); ?>

<div class="inner contest">

	<div id="contest-photo">
		<div class="top">
			<div class="user-box clearfix">
				<?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $work->author)); ?>
			</div>
		</div>
		<div class="img-box">
			<div class="img-in"><?php echo CHtml::image($work->work_image->getUrl('big'), $work->work_title); ?></div>
			<div class="img-title"><?php echo $work->work_title; ?></div>
		</div>
	</div>

    <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
        'title' => 'Вам понравилось фото?',
        'model' => $work,
        'options' => array(
            'title' => $work->work_title,
            'image' => $work->work_image->getUrl('big'),
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
						<?php echo CHtml::link(CHtml::image($w->work_image->getUrl('thumb'), $w->work_title), $this->createUrl('/contest/work/' . $w->work_id)); ?>
					</div>
					<div class="item-title"><?php echo $w->work_title; ?></div>
					<div class="mark">
						<span><?php echo Rating::model()->countByEntity($w); ?></span> баллов
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