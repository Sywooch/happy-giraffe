<h1>Вопросы, ответы и результаты ответов</h1>
<?php foreach ($questionnaire->results as $result): ?>
    <?php if ($result->type == 0): ?>
        <input type="hidden" value="<?= $result->id; ?>" name="<?= $result->value; ?>" class="result-input" />
    <?php else: ?>
        <input type="hidden" value="<?= $result->id; ?>" name="<?= $result->photo->original_name; ?>" class="result-input" />
        <div style="display:inline-block; width: 100px; height: 100px;">
            <?= $result->photo->original_name; ?><br/>
            <img src="<?= \Yii::app()->thumbs->getThumb($result->photo, 'smallPostPreview'); ?>" />
        </div>
    <?php endif; ?>
<?php endforeach; ?>
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
    function createResult(id, answer_id){
        var html = '<select id="select_'+id+'_'+answer_id+'" data-id="'+id+' data-answer-id="'+answer_id+'"">';
        $('.result-input').each(function(){
            html += '<option value="'+$(this).attr('value')+'">'+$(this).attr('name')+'</option>';
        });
        html += '</select>';
        return html;
    }

    function addAnswer(id){
        var counter = $('#question_wrap_'+id).children('.answerInput').length;
        $('#question_wrap_'+id).append('<br/><input id="answer_'+id+'_'+counter+'" placeholder="Ответ" class="answerInput" type="text" data-id="'+id+'""/>' +
            ' <span>-></span> '+createResult(id, counter));
        $('#question_wrap_'+id).append('<a onclick="deleteAnswer('+id+','+counter+');">Удалить</a>');
    }

    function deleteAnswer(id, counter)
    {
        $('#select_'+id+'_'+counter).next('a').remove();
        $('#select_'+id+'_'+counter).remove();
        $('#answer_'+id+'_'+counter).next('span').remove();
        $('#answer_'+id+'_'+counter).prev('br').remove();
        $('#answer_'+id+'_'+counter).remove();
    }

    function deleteQuestion(id)
    {
        $('#question_wrap_'+id).remove();
    }

    $(document).ready(function(){
        $('#addQuestion').click(function(){
            var counter = $('.questionInput').length;
            $('#questionForm').append('<div id="question_wrap_'+counter+'" class="questionWrap"></div>');
            $('#question_wrap_'+counter).append('<input type="text" placeholder="Вопрос" class="questionInput" data-id="'+counter+'"/>');
            $('#question_wrap_'+counter).append('<input type="button" class="addAnswer" onclick="addAnswer('+counter+')" value="Добавить ответ" />');
            $('#question_wrap_'+counter).append('<a onclick="deleteQuestion('+counter+');">Удалить</a><br/>');
        });
        $('#save').click(function(){
            var arr = [];
            $('.questionWrap').each(function(){
                var id = $(this).children('.questionInput').data('id');
                var question = $(this).children('.questionInput').val();
                arr.push(id);
                arr[id] = new Array();
                $(this).children('.answerInput').each(function(index){
                    arr[id].push({
                        'question': question,
                        'answer': $(this).val(),
                        'result': $(this).next().next().val()
                    });
                });
            });

            $.post('?r=questionnaire/default/add2&questionnaire_id=<?php echo $id; ?>', {result: JSON.stringify(arr)}, function(response){
                alert('test');
            }, "json");
        });
    });
</script>

<div id="questionForm">

</div>


<button id="addQuestion" style="border: 1px solid green;">Добавить вопрос</button>
<button id="save" style="border: 1px solid green;">Сохранить</button>