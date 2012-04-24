<?php
$this->breadcrumbs=array(
	'Возраст и пол',
);
?>

<h1>Возраст и пол</h1>

<h3>Возраст</h3>
<ul>
	<?php foreach ($ages as $age): ?>
    <li><?php echo CHtml::link($age['title'], array('age', 'id'=>$age['id'])); ?></li>
	<?php endforeach; ?>
</ul>

<h3>Пол</h3>
<ul>
	<?php foreach ($sexList as $id=>$sex): ?>
    <li><?php echo CHtml::link($sex, array('gender', 'id'=>$id)); ?></li>
	<?php endforeach; ?>
</ul>