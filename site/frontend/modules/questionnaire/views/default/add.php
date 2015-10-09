<h1>Название и возможные результаты</h1>

<script>
    function deleteResult(id){
        $('#text-'+id).remove();
        $('#btn-'+id).next('br').remove();
        $('#btn-'+id).remove();
    }

    $(document).ready(function(){
        $('#addText').click(function(){
            var counter = $('.textInput').length;
            $('#yw0').append('<input type="text" placeholder="Возможный результат" style="border: 1px solid black;" name="text-'+counter+'" id="text-'+counter+'" class="textInput" /><a id="btn-'+counter+'"onclick="deleteResult('+counter+');">Удалить</a> <br />');
        });
    });
</script>

<div class="form" action="" method="post">
    <?php $form = $this->beginWidget('CActiveForm'); ?>
        <?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->label($model, 'text'); ?>
            <?php echo $form->textField($model, 'text'); ?>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton('Сохранить'); ?>
        </div>
    <?php $this->endWidget(); ?>
</div>

<button id="addText" style="border: 1px solid green;">Добавить текстовый результат</button>