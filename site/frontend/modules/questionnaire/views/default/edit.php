<h1>Название и возможные результаты</h1>

<style>
    .text-field{
        border: 1px solid black;
    }
</style>

<script>
    $(document).ready(function(){
        $('#nameSave').click(function(){
            var id = $(this).prev().attr('id');
            var name = $(this).prev().val();
            $.post('?r=questionnaire/default/saveQuestionnaire&questionnaire_id='+id, { name: name}, function(response){}, "json");
        });
    });

    function saveResult(id)
    {
        var text = $('#result_'+id).val();
        $.post('?r=questionnaire/default/saveResult&result_id='+id, { text: text}, function(response){}, "json");
    }

    function deleteResult(id)
    {
        $.post('?r=questionnaire/default/deleteResult&result_id='+id, {}, function(response){}, "json");
    }
</script>

Название:<input type="text" class="text-field" placeholder="Название" name="name" id="<?= $questionnaire->id; ?>" value="<?= $questionnaire->name; ?>"/>
<a id="nameSave">Сохранить</a><br/>
Результаты:<br/>
<?php foreach ($questionnaire->results as $key => $result): ?>
    <?php if ($result->type == 0): ?>
        <input type="text" class="text-field" placeholder="Текстовый результат" id="result_<?= $result->id ?>" name="text-<?= $key; ?>" value="<?= $result->value ?>" />
        <a onclick="saveResult(<?= $result->id; ?>)">Сохранить</a>
        <a onclick="deleteResult(<?= $result->id; ?>)">Удалить</a><br/>
    <?php else: ?>
        <img src="<?= \Yii::app()->thumbs->getThumb($result->photo, 'smallPostPreview'); ?>" />
        <a onclick="deleteResult(<?= $result->id; ?>)">Удалить</a><br/>
    <?php endif; ?>
<?php endforeach ?>

<a href="?r=questionnaire/default/edit2&questionnaire_id=<?= $questionnaire->id; ?>">Далее</a>
<!--<button id="addText" style="border: 1px solid green;">Добавить текстовый результат</button>-->