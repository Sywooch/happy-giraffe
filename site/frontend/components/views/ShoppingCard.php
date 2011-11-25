<div id="ShoppingCard">
	<?php
	echo "In shopping card: "
	. Yii::app()->shoppingCart->getCount()
	. " items (" . Yii::app()->shoppingCart->getItemsCount()
	. " total) (" . Yii::app()->shoppingCart->getCost(false)
	. " руб, со скидкой " . Yii::app()->shoppingCart->getCost(true)
	. " руб)";
	?>
</div>

<?php echo CHtml::beginForm(array('/shop/useVaucher'), 'get'); ?>
<div class="row">
	<?php echo CHtml::textField('code', '', array('size' => 10, 'maxlength' => 255)); ?>
	<?php echo CHtml::submitButton('use'); ?>
</div>
<?php echo CHtml::endForm(); ?>

<?php echo CHtml::link('Show', array('/shop/shopCart')); ?>