<?php
use \CHtml;

\Yii::app()->clientScript->useAMD = false;
?>

<?php echo CHtml::beginForm(['create'],'get'); ?>

<div class="form-group">
    <input type="text" name="type" placeholder="Тип" class="form-control">
</div>

<div class="form-group">
    <input type="text" name="url" placeholder="Ссылка" class="form-control">
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">Сохранить</button>
</div>

<?php echo CHtml::endForm(); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'indexing-url-grid',
    'dataProvider'=>$model->search(),
    'ajaxUpdate'=>false,
    'columns'=>array(
        'id',
        'type',
        'key',
        'description',
        'created',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{delete}{view}',
            'buttons'=>array(
                'view'=>
                    array(
                        'url'=>'Yii::app()->createUrl("/iframe/admin/default/viewCode", array("id"=>$data->id))',
                    ),
            ),
        ),

    ),
)); ?>