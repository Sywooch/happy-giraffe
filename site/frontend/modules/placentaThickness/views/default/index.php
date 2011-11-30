<?php
/* @var $model PlacentaThicknessForm
 * @var $form CActiveForm
 */

$js = '';

?>
<style type="text/css">
    input{
        border: 1px solid #000;
    }
</style>
<script type="text/javascript">
    $(function() {
        $('#placenta-thickness-form button').click(function(){
            $.ajax({
                url: "<?php echo Yii::app()->createUrl("/placentaThickness/default/calculate") ?>",
                data: $("#placenta-thickness-form").serialize(),
                type: "POST",
                success: function(data) {
                    $('#result').html(data);
                }
            });
            return false;
        });
    });
</script>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'placenta-thickness-form',
    'enableAjaxValidation' => false,
));?>
<?php echo $form->textField($model, 'week') ?><br>
<?php echo $form->textField($model, 'thickness') ?><br>
<button>Расчитать</button>
<?php $this->endWidget(); ?>
<div id="result">

</div>