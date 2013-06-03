<?=CHtml::beginForm(array('/search/default/index'), 'get')?>
<?=CHtml::textField('query')?>
<?=CHtml::dropDownList('len', '10', array('10' => '10', '25' => '25', '50' => '50'))?>
<?=CHtml::endForm()?>

Общее количесто результатов: <?=$total?>