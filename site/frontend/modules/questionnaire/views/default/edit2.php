<style>
    .questionInput{
        border: 1px solid black;
    }
    .addAnswer{
        display: inline-block;
        border: 1px solid green;
    }
    .answerInput {
        border: 1px solid black;
        margin-left: 30px;
    }
</style>

<script>
    $(document).ready(function(){

    });

    function createResults()
    {
        var html = '<select id="select_'+id+'_'+answer_id+'" data-id="'+id+' data-answer-id="'+answer_id+'"">';
        $('.result-input').each(function(){
            html += '<option value="'+$(this).attr('value')+'">'+$(this).attr('name')+'</option>';
        });
        html += '</select>';
        return html;
    }

    function saveQuestion(id)
    {
        var text = $('#question_'+id).val();
        $.post('?r=questionnaire/default/saveQuestion&question_id='+id, { text: text }, function(){}, "json");
    }

    function saveAnswer(id, question_id)
    {
        var text = $('#answer_'+id).val();
        var result_id = $('#select_'+question_id+'_'+id).val();
        $.post('?r=questionnaire/default/saveAnswer&answer_id='+id, { text: text, result: result_id }, function(){}, "json");
    }

    function deleteQuestion(id)
    {
        $('#question_wrap_'+id).remove();
        $.post('?r=questionnaire/default/deleteQuestion&question_id='+id, { }, function(){}, "json");
    }

    function deleteAnswer(id)
    {
        $('#answer_wrap_'+id).remove();
        $.post('?r=questionnaire/default/deleteAnswer&answer_id='+id, { }, function(){}, "json");
    }
</script>
<?php foreach ($questionnaire->results as $result): ?>
    <?php if ($result->type == 0): ?>
        <input type="hidden" class="result" name="<?= $result->value; ?>" value="<?= $result->id; ?>"/>
    <?php else: ?>
        <input type="hidden" class="result" name="<?= $result->photo->original_name; ?>" value="<?= $result->id; ?>"/>
        <div style="display:inline-block; width: 100px; height: 100px;">
            <?= $result->photo->original_name; ?><br/>
            <img src="<?= \Yii::app()->thumbs->getThumb($result->photo, 'smallPostPreview'); ?>" />
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php foreach ($questionnaire->questions as $question): ?>
    <div id="question_wrap_<?= $question->id; ?>">
    <input class="questionInput" type="text" id="question_<?= $question->id; ?>" value="<?= $question->text; ?>" data-stage="<?= $question->stage; ?>"/>
    <a onclick="saveQuestion(<?= $question->id; ?>)">Сохранить</a>
    <a onclick="deleteQuestion(<?= $question->id; ?>)">Удалить</a><br/>
    <?php foreach ($question->answers as $answer): ?>
        <div id="answer_wrap_<?= $answer->id; ?>">
            <input class="answerInput" type="text" id="answer_<?= $answer->id?>" value="<?= $answer->text?>" />
            <select id="select_<?= $question->id; ?>_<?= $answer->id; ?>" data-id="<?= $question->id; ?>" data-answer-id="<?= $answer->id; ?>">
            <?php foreach ($questionnaire->results as $result): ?>
                <?php if ($result->type == 0): ?>
                    <option <?php if ($answer->result_id == $result->id): ?> selected <?php endif; ?> value="<?= $result->id; ?>"><?= $result->value; ?></option>
                <?php else: ?>
                    <option <?php if ($answer->result_id == $result->id): ?> selected <?php endif; ?> value="<?= $result->id; ?>"><?= $result->photo->original_name; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
            </select>
            <a onclick="saveAnswer(<?= $answer->id; ?>, <?= $question->id; ?>)">Сохранить</a>
            <a onclick="deleteAnswer(<?= $answer->id; ?>)">Удалить</a><br/>
        </div>
    <?php endforeach; ?>
    </div>
<?php endforeach; ?>
