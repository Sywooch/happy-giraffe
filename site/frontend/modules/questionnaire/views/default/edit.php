<h1>Название и возможные результаты</h1>

<style>
    .text-field{
        border: 1px solid black;
    }
</style>

<script>
    $(document).ready(function(){
        /*$('#addText').click(function(){
            var counter = $('.textInput').length;
            $('#editForm').append('<input type="text" placeholder="Возможный результат" style="border: 1px solid black;" name="text-'+counter+'" id="text-'+counter+'" class="textInput" /><a id="btn-'+counter+'"onclick="deleteResult('+counter+');">Удалить</a> <br />');
        });*/

        $('#nameSave').click(function(){
            var id = $(this).prev().attr('id');
            var name = $(this).prev().val();
            $.post('?r=questionnaire/default/saveQuestionnaire&questionnaire_id='+id, { name: name}, function(response){}, "json");
        });

        $('.resultSave').click(function(){
            var id = $(this).prev().attr('id');
            var text = $(this).prev().val();
            $.post('?r=questionnaire/default/saveResult&result_id='+id, { text: text}, function(response){}, "json");
        });
    });
</script>

Название:<input type="text" class="text-field" placeholder="Название" name="name" id="<?= $questionnaire->id; ?>" value="<?= $questionnaire->name; ?>"/> <a id="nameSave">Сохранить</a><br/>
Результаты:<br/>
<?php foreach ($results as $key => $result): ?>
    <input type="text" class="text-field" placeholder="Текстовый результат" id="<?= $result->id ?>" name="text-<?= $key; ?>" value="<?= $result->value ?>" /> <a class="resultSave">Сохранить</a><br/>
<?php endforeach ?>

<a href="?r=questionnaire/default/edit2&questionnaire_id=<?= $questionnaire->id; ?>">Далее</a>
<!--<button id="addText" style="border: 1px solid green;">Добавить текстовый результат</button>-->