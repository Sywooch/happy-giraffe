<div class="item-box<?php if ($item->for == BagItem::FOR_CHILD) echo ' item-box-pink'; ?>">
	<div class="box-in">
		<span class="valign"></span>
		<span><?php echo $item->name; ?></span>
		<?php if ($item->description): ?><div class="hint"><?php echo $item->description; ?></div><?php endif; ?>
		<div class="drag"></div>
		<?php echo CHtml::hiddenField('id', $item->id); ?>
	</div>
</div>