<h1>Сообщества</h1>

<ul>
	<? foreach ($communities as $c): ?>
		<li><?=CHtml::link($c->name, $this->createUrl('community/list', array('community_id' => $c->id)))?></li>
	<? endforeach; ?>
</ul>