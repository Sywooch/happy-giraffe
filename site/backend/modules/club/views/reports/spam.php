<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <p>
        <?php echo $form->label($model,'accepted'); ?>
        <?php echo $form->dropDownList($model, 'accepted', $model->accepted_types, array('onchange' => "$(this).parents('form').submit();")); ?>
    </p>
<?php $this->endWidget(); ?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$model->spam(),
    'columns' => array(
        array(
            'name' => 'breaker.fullName',
            'header' => 'Нарушитель',
        ),
        'count',
        array(
            'name' => 'created',
            'header' => 'Последняя жалоба',
            'type' => 'raw',
            'value' => 'HDate::GetFormattedTime($data->created, \', \')',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("Открыть", array("reports/spamView", "id" => $data->breaker_id));'
        ),
    )
));
?>
<script type="text/javascript">
    function acceptReport(link) {
        if(!confirm("Отметить как проверенное?"))
            return false;
        $.get(link.href, function() {$(link).parents("tr").remove();});
        return false;
    }
</script>