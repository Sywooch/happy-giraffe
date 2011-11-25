<h1>Конкурсы</h1>

<ul>
	<? foreach ($contests as $c): ?>
		<li><?=CHtml::link($c->contest_title, Yii::app()->urlManager->createUrl('/contest/' . $c->contest_id))?></li>
	<? endforeach; ?>
</ul>