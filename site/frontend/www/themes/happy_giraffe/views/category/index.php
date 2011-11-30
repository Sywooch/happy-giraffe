<?php
$this->breadcrumbs = array(
	'Категории',
);

$this->menu = array(
	array('label' => 'Create Category', 'url' => array('create')),
	array('label' => 'Manage Category', 'url' => array('admin')),
);
?>

<h1>Категории</h1>

<?php
$level = 0;
foreach ($categories as $n => $category) {
	if ($category['category_level'] == $level){
		echo CHtml::closeTag('li') . "\n";
	}
	else if ($category['category_level'] > $level) {
		echo CHtml::openTag('ul', array(
			'style' => 'padding: 2px 0 0 20px;',
		)) . "\n";
	}
	else {
		echo CHtml::closeTag('li') . "\n";
		for ($i = $level - $category['category_level']; $i; $i--) {
			echo CHtml::closeTag('ul') . "\n";
			echo CHtml::closeTag('li') . "\n";
		}
	}
	echo CHtml::openTag('li');
	echo CHtml::link($category['category_name'], array('view', 'id' => $category['category_id']));
	$level = $category['category_level'];
}
for ($i = $level; $i; $i--) {
	echo CHtml::closeTag('li') . "\n";
	echo CHtml::closeTag('ul') . "\n";
}
?>
