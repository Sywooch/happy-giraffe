<ul>
	<? foreach ($contests as $c): ?>
		<li><?=CHtml::link($c->title, array('/contest/default/list', 'id' => $this->contest->id))?></li>
	<? endforeach; ?>
</ul>