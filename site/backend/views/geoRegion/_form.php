<?php
/* @var $model GeoRegion
 * @var $form CActiveForm
 */
?><?php echo CHtml::link('К таблице', array('GeoRegion/admin')) ?><div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'geo-region-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?=$model->country->name ?>
	</div>

	<div class="row">
        <?=$model->name ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'center_id'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'sourceUrl' =>'/geoRegion/autoComplete/?region_id='.$model->id,
            'name' => 'ac',
            'id' => 'ac',
        ));

        echo $form->hiddenField($model, 'center_id');
        ?>
		<?php echo $form->error($model,'center_id'); ?>
	</div>

	<div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?= CHtml::submitButton('Сохранить') ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    var Geo = {
        acSelect:function (event, ui) {
            //console.log(ui.item);
            $('#GeoRegion_center_id').val(ui.item.id);
        }
    }

    $(function () {
        $("#ac").bind("autocompleteselect", Geo.acSelect);
    })
</script>