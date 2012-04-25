<?php foreach ($contents as $c): ?>
	<p><?php echo CHtml::link($c->name, array('community/view',
		'community_id' => $c->rubric->community->id,
		'content_type_slug' => $c->type->slug,
		'content_id' => $c->id,
	)); ?></p>
<?php endforeach; ?>