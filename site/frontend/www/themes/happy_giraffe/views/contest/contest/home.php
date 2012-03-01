<?php $this->breadcrumbs = array(
		'Конкурсы' => $this->createUrl('/contest'),
		$contest->contest_title => array('/contest/' . $contest->contest_id),
	); ?>

<div class="inner contest">
	<div class="left-inner">
		<div class="content-title">О конкурсе</div>
		<p>Удивительное время - осень. Яркое и переменчивое. И когда природа перестает моросить, и дети, и взрослые с удовольствием выходят на улицы. Мамочки неторопливо катят коляски, дети скачут между деревьями и норовят зарыться в кучи листьев. Малыши находят свои первые сокровища и радостно несут их папе или маме. Прогуляться всей семьей по осеннему парку  или бульвару - это особенное удовольствие.</p>
	</div>
	<div class="right-inner">
		<div class="sticker">
			<big>Для участия в конкурсе Вам необходимо</big>
			<ul>
				<li>Заполнить профиль;</li>

				<li>Добавить информацию о ребенке (возраст и имя);</li>

				<li>Написать хотя бы один пост в блоге/сообществе.</li>
			</ul>
			<a href="<?php echo Yii::app()->user->isGuest ? '#login' : '#takeapartPhotoContest'; ?>" class="btn btn-green-arrow-big fancy"><span><span>Участвовать</span></span></a>
		</div>
		
		
	</div>			
	<div class="clear"></div>
	<div class="content-title">Вас ждут замечательные призы!</div>
		
	<div class="prise-block" style="margin-bottom: 20px;">
		<?php foreach ($contest->prizes as $p): ?>
			<div class="item">
				<?php echo CHtml::image(str_replace('club', 'shop', $p->product->product_image->getUrl('product_contest')), $p->product->product_title); ?>
				<span><?php echo $p->prize_place; ?> место</span>
				<p><?php echo $p->prize_text; ?></p>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="clear"></div>
	<div class="photo-block">
		<div class="content-title">
			Последние добавленные фото
			<a href="<?php echo $this->createUrl('/contest/list/' . $contest->contest_id); ?>" class="btn btn-blue-small"><span><span>Показать все</span></span></a>
		</div>
		
		<ul class="photo-list">
			<?php foreach ($contest->works as $w): ?>
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
	
	
</div>