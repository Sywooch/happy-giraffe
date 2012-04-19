<ul>
	<? foreach ($contests as $c): ?>
		<li><?=CHtml::link($c->title, Yii::app()->urlManager->createUrl('/contest/' . $c->id))?></li>
	<? endforeach; ?>
</ul>