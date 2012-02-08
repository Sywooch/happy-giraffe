<?php
foreach($this->providers as $provider => $options)
{
    $this->render('_' . $provider, array(
        'options' => $options,
    ));
}
$js = "function rate(count, key)
{
	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {
			modelName: '" . get_class($this->model) . "',
			objectId: {$this->model->primaryKey},
			r: count,
			key : key
		},
		url: '" . Yii::app()->createUrl('/ajax/rate') . "',
		success: function(response) {
			$('div.rate').text(response);
		}
	});
}";
Yii::app()->clientScript
    ->registerScript('social_rate', $js, CClientScript::POS_HEAD);
?>