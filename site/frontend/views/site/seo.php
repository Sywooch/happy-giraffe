<style>
    input, button {
        background: #fff;
    }
</style>

<?=CHtml::beginForm()?>
Период 1 от <?=CHtml::textField('period1Start')?> до <?=CHtml::textField('period1End')?><br>
Период 2 от <?=CHtml::textField('period2Start')?> до <?=CHtml::textField('period2End')?><br>
<button>Отправить</button>
<?=CHtml::endForm()?>

<?php if ($dp !== null): ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider' => $dp,
    'columns' => array(
        array(
            'name' => 'Ссылка',
            'type' => 'raw',
            'value' => 'CHtml::link(\'http://www.happy-giraffe.ru\' . $data["id"], \'http://www.happy-giraffe.ru\' . $data["id"])',
        ),
        array(
            'name' => 'period1',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["period1"])',
        ),
        array(
            'name' => 'period2',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["period2"])',
        ),
        array(
            'name' => 'diff',
            'type' => 'raw',
            'value' => 'CHtml::encode($data["diff"])',
        ),
    ),
));
?>
<?php endif; ?>