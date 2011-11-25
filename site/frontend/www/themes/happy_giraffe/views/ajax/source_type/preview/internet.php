<?php echo CHtml::hiddenField('internet_title', $title); ?>
<?php echo CHtml::hiddenField('internet_favicon', $favicon); ?>
<?php echo CHtml::image(Yii::app()->request->baseUrl . '/upload/favicons/' . $favicon, $title); ?>
<?php echo CHtml::tag('div', array('class' => 'name'), $title); ?>
<a href="" class="del">
	Удалить
</a>
<div class="clear"></div>