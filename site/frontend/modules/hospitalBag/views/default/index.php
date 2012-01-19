<?php
	$cs = Yii::app()->clientScript;

	$js = "
		$('.item-box').draggable({
			handle: '.drag',
			revert: true,
		});
		
		$('.items-storage, .item-storage').droppable({

			drop: function(event, ui) {
				$.ajax({
					dataType: 'JSON',
					type: 'POST',
					url: " . CJSON::encode(Yii::app()->createUrl('hospitalBag/default/putIn')) . ",
					data: {
						id: ui.draggable.find('input[name=\"id\"]').val()
					},
					success: function(response) {
						if (response.success)
						{
							ui.draggable.remove();
							$('span.count').text(response.count);
						}
					}
				});
			}
		});
		
		$('#addOffer').delegate('button.cancel', 'click', function(e) {
			e.preventDefault();
			$('#BagItem_description').val('');
		});
		
		$('#BagItem_description').focus(function() {
			$('#BagItem_description').val('');
		});
		
		$('#BagItem_name').focus(function() {
			$('#BagItem_name').val('');
		});
	";

	$cs
		->registerCoreScript('jquery.ui')
		->registerScript('service_bag', $js);
?>

<div class="section-banner" style="margin:0;">
	<img src="/images/section_banner_07.jpg" />
</div>

<div class="tabs vaccination-tabs">
	<div class="nav" style="margin:0;">
		<ul>
			<?php $j = 0; foreach ($visible_items as $c): ?>
				<li<?php if ($j == 0) echo ' class="active"'; ?>>
					<a href="javascript:void(0);" onclick="setTab(this, <?php echo $c->id; ?>);">
						<div class="box-in">
							<span><?php echo $c->name; ?> </span>
						</div>
					</a>
				</li>
			<?php $j++; endforeach; ?>
		</ul>
	</div>
	<div class="hospital-bag">
		<div class="items">
			<?php $j = 0; foreach ($visible_items as $c): ?>
				<div class="tab-box tab-box-<?php echo $c->id; ?>"<?php if ($j == 0) echo ' style="display:block;"'; ?>>
					<?php foreach ($c->items as $i): ?>
						<?php $this->renderPartial('_item', array('item' => $i)); ?>
					<?php endforeach; ?>
				</div>
			<?php $j++; endforeach; ?>

		</div>

		<div class="items-storage">
			<div class="storage-text">
				Перетащите сюда<br/>необходимое Вам
				<span>В сумке предметов: <span class="count"><?php echo $count; ?></span></span>
				<!--<a href="" class="btn btn-green-small"><span><span>Показать</span></span></a>-->
			</div>
		</div>
	</div>
</div>

<div class="steps steps-comments">
	<a href="#addOffer" class="btn btn-orange a-right"><span><span>Добавить предмет</span></span></a>
	<ul>
		<li class="active"><a>Что бы Вы положили в сумку? </a></li>
	</ul>
	<div class="comment-count"><?php echo $offers->totalItemCount; ?></div>
</div>

<div class="comments">
	<ul>
		<?php foreach ($offers->data as $o): ?>
			<li class="clearfix even">
				<div class="user">
					<?php $this->widget('AvatarWidget', array('user' => $o->author)); ?>
					<a class="username"><?php echo $o->author->first_name; ?></a>
				</div>
				<div class="content">
					<div class="hospital-bag-item-fast">
						<div class="item-storage">Ко мне в сумку</div>
						<?php if (! in_array($o->item->id, Yii::app()->user->getState('hospitalBag', array()))): ?>
							<?php $this->renderPartial('_item', array('item' => $o->item)); ?>
						<?php endif; ?>
					</div>
					<p><?php echo $o->item->description; ?></p>
					<?php if (! Yii::app()->user->isGuest): ?>
						<div class="item-useful">
							Предмет нужен?
                            <?php $this->widget('VoteWidget', array(
                            'model'=>$o,
                            'template'=>'<div class="green">
                                <a vote="1" class="btn btn-gray-small{active1}" href=""><span><span>Да</span></span></a>
                                <br>
                                <b><span class="votes_pro">{vote1}</span> (<span class="pro_percent">{vote_percent1}</span>%)</b>
                            </div>
                            <div class="red">
                                <a vote="0" class="btn btn-gray-small{active0}" href=""><span><span>Нет</span></span></a>
                                <br>
                                <b><span class="votes_con">{vote0}</span> (<span class="con_percent">{vote_percent0}</span>%)</b>
                            </div>',
                            'links' => array('.red','.green'),
                            'result'=>array(0=>array('.votes_con','.con_percent'),1=>array('.votes_pro','.pro_percent')),
                            'main_selector'=>'.item-useful'
                            )); ?>
<!--							<div class="green"><a href="" class="btn btn---><?php //echo ($o->vote == 1) ? 'green':'gray'; ?><!---small"><span><span>Да</span></span></a><br/><b><span class="votes_pro">--><?php //echo $o->votes_pro; ?><!--</span> (<span class="pro_percent">--><?php //echo $o->getPercent(1); ?><!--</span>%)</b></div>-->
<!--							<div class="red"><a href="" class="btn btn---><?php //echo ($o->vote == 0 && $o->vote !== null) ? 'red':'gray'; ?><!---small"><span><span>Нет</span></span></a><br/><b><span class="votes_con">--><?php //echo $o->votes_con; ?><!--</span> (<span class="con_percent">--><?php //echo $o->getPercent(0); ?><!--</span>%)</b></div>-->
<!--							--><?php //echo CHtml::hiddenField('id', $o->id); ?>
						</div>
					<?php endif; ?>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php if (! Yii::app()->user->isGuest): ?>
		<div class="add clearfix">
			<div class="new-comment">
				<?php
					$form = $this->beginWidget('CActiveForm', array(
						'action' => 'hospitalBag/default/addOffer',
						'id' => 'addOffer',
					));
				?>
					<div class="new-hospital-bag-item">
						Ваш предмет: <?php echo $form->textField($item, 'name'); ?> <span>Добавляйте только по одному предмету!</span>
					</div>

					<?php $item->description = 'Напишите для чего может пригодиться этот предмет в роддоме.'; echo $form->textArea($item, 'description'); ?>
					<button class="btn btn-gray-medium cancel"><span><span>Отменить</span></span></button>
					<button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	<?php endif; ?>
</div>
<script type="text/javascript">
	$(' .item-box').hover(function(){
		$(this).find('.hint').stop(true, true).fadeIn();
	}, function(){
		$(this).find('.hint').stop(true, true).fadeOut();
	})
</script>