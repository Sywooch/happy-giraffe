<?php
	$description = $item->description;
	if (mb_strpos($description, " ", 0, 'utf-8') !== FALSE)
	{
		$length = mb_strlen($description, 'utf-8');
		$center = round($length / 2);
		$center_to_left = mb_strrpos($description, ' ', -$center, 'utf-8');
		$center_to_right = mb_strpos($description, ' ', $center, 'utf-8') - $center;
		
		if ($center_to_left > $center_to_right)
		{
			$lol = mb_substr($description, 0, $center + $center_to_right, 'utf-8') . '<br />' . mb_substr($description, $center + $center_to_right + 1, 999, 'utf8');
		}
		else
		{
			$lol = mb_substr($description, 0, $center - $center_to_left, 'utf-8') . '<br />' . mb_substr($description, $center - $center_to_left + 1, 999, 'utf8');
		}
	}
	else
	{
		$lol = $description;
	}
?>

<div class="item-box<?php if ($item->for == BagItem::FOR_CHILD) echo ' item-box-pink'; ?>">
	<div class="box-in">
		<span class="valign"></span>
		<span><?php echo $item->title; ?></span>
		<?php if ($item->description): ?><div class="hint"><?php echo $lol; ?></div><?php endif; ?>
		<div class="drag"></div>
		<?php echo CHtml::hiddenField('id', $item->id); ?>
	</div>
</div>