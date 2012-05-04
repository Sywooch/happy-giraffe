<ul>
	<?php foreach ($recipies as $r): ?>
		<li><?php echo CHtml::link($r->title, $this->createUrl('edit', array('id' => $r->id))); ?></li>
	<?php endforeach; ?>
</ul>