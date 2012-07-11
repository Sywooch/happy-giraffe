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
    'dataProvider'=>$model->search(),
    'columns' => array(
        'id',
        array(
            'name' => 'type',
            'value' => '$data->types[$data->type]',
        ),
        array(
            'header' => 'Нарушитель',
            'type' => 'raw',
            'value' => '$data->model->author->fullName'
        ),
        array(
            'name' => 'path',
            'type' => 'raw',
            'value' => 'CHtml::link($data->path, Yii::app()->params["frontend_url"] . $data->path)'
        ),
        array(
            'name' => 'author.fullName',
            'type' => 'html',
            'value' => '$data->author ? $data->author->fullName : "Гость"',
        ),
        array(
            'name' => 'text',
            'type' => 'raw',
            'value' => 'Str::truncate(trim(strip_tags($data->text)), 100, "...");'
        ),
        array(
            'name' => 'created',
            'type' => 'raw',
            'value' => 'HDate::GetFormattedTime($data->created, \', \')',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{accept}',
            'buttons' => array(
                'accept' => array(
                    'label' => 'Проверено',
                    'url' => 'Yii::app()->createUrl("reports/accept", array("id" => $data->primaryKey))',
                    'options' => array(
                        'onclick' => 'return acceptReport(this)',
                    ),
                    'visible' => '$data->accepted == 0'
                ),
            ),
        )
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