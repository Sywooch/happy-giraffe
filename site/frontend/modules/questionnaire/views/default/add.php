<h1>Название и возможные результаты</h1>

<script>
    function deleteTextResult(id){
        $('#text-'+id).remove();
        $('#btn-text-'+id).next('br').remove();
        $('#btn-text-'+id).remove();
    }

    function deleteImageResult(id){
        $('#image-'+id).remove();
        $('#btn-image-'+id).next('br').remove();
        $('#btn-image-'+id).remove();
    }

    $(document).ready(function(){
        $('#addText').click(function(){
            var counter = $('.textInput').length;
            $('#yw0').append('<input type="text" placeholder="Возможный результат" style="border: 1px solid black;" name="text-'+counter+'" id="text-'+counter+'" class="textInput" /><a id="btn-text-'+counter+'"onclick="deleteTextResult('+counter+');">Удалить</a> <br />');
        });

        $('#addImage').click(function(){
            var counter = $('.imageInput').length;
            $('#yw0').append('<input type="file" name="image-'+counter+'" id="image-'+counter+'" class="imageInput" /><a id="btn-image-'+counter+'" onclick="deleteImageResult('+counter+');">Удалить</a> <br/>');
        });
    });
</script>

<div class="form" action="" method="post">
    <?php $form = $this->beginWidget('CActiveForm', array('htmlOptions' => array('enctype' => 'multipart/form-data'))); ?>
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

<button id="addText" style="border: 1px solid green;">Добавить текстовый результат</button><br/>
<button id="addImage" style="border: 1px solid green;">Добавить картинку</button><br/>