<?php
	$cs = Yii::app()->clientScript;

	$js = "
		$('.item').draggable({
			handle: 'span'
		});
		
		$('#bag, .mini_bag').droppable({
			accept: '.item',
			drop: function(event, ui) {
				$.ajax({
					dataType: 'JSON',
					type: 'POST',
					url: " . CJSON::encode(Yii::app()->createUrl('hospitalBag/default/putIn')) . ",
					data: {
						id: ui.draggable.children('input[name=\"id\"]').val()
					},
					success: function(response) {
						if (response.success)
						{
							ui.draggable.remove();
						}
					}
				});
			}
		});
		
		$('.offer').delegate('button', 'click', function() {
			var offer = $(this).parent('.offer');
			var a = {pro: 1, con: 0};
			var class = $(this).attr('class').split(' ')[1];
			var vote = a[class];
			var offer_id = offer.children('input[name=\"id\"]').val();
			$.ajax({
				dataType: 'JSON',
				type: 'POST',
				url: " . CJSON::encode(Yii::app()->createUrl('hospitalBag/default/vote')) . ",
				data: {
					offer_id: offer_id,
					vote: vote,
				},
				success: function(response) {
					offer.children('span.votes_pro').text(response.votes_pro);
					offer.children('span.votes_con').text(response.votes_con);
					offer.children('span.pro_percent').text(response.pro_percent);
					offer.children('span.con_percent').text(response.con_percent);
				},
			});
		});
	";
	
	$css = "
		.item {
			border: 1px solid #000;
			background: #ccc;
			margin: 5px;
			padding: 3px;
			display: inline-block;
		}
		
			.item span {
				border: 1px solid #000;
				cursor: pointer;
			}
		
		#bag {
			border: 1px solid #000;
			width: 100px;
			height: 100px;
		}
		
		.mini_bag {
			border: 1px solid #000;
			width: 100px;
			height: 30px;
		}
	";
	
	$cs
		->registerCoreScript('jquery.ui')
		->registerScript('service_bag', $js)
		->registerCss('service_bag', $css);
?>

<?php
	foreach ($visible_items as $c)
	{
		foreach ($c->items as $i)
		{
			$this->renderPartial('_item', array('item' => $i));
		}
	}
?>
<div id="bag"></div>

<?php foreach ($offers->data as $o): ?>
<div class="offer">
	<?php if (! in_array($o->item->id, Yii::app()->user->getState('hospitalBag', array()))): ?>
		<?php $this->renderPartial('_item', array('item' => $o->item)); ?>
	<?php endif; ?>
	<?php echo $o->item->description; ?>
	<div class="mini_bag"></div>
	<?php if (! Yii::app()->user->isGuest): ?>
		<button class="vote pro">Да</button> <?php echo '<span class="votes_pro">' . $o->votes_pro . '</span>' . '(<span class="pro_percent">' . $o->proPercent . '</span>%)'; ?>
		<button class="vote con">Нет</button> <?php echo '<span class="votes_con">' . $o->votes_con . '</span>' . '(<span class="con_percent">' . $o->conPercent . '</span>%)'; ?>
	<?php endif; ?>
	<?php echo CHtml::hiddenField('id', $o->id); ?>
	<hr />
</div>
<?php endforeach; ?>

<?php
	$form = $this->beginWidget('CActiveForm', array(
		'action' => 'hospitalBag/default/addOffer',
	));
?>

<?php if (! Yii::app()->user->isGuest): ?>
	Ваш предмет: <?php echo $form->textField($item, 'name'); ?>
	Описание: <?php echo $form->textArea($item, 'description'); ?>
	<button>Добавить</button>
<?php endif; ?>

<?php $this->endWidget(); ?>