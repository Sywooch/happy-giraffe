var Duel = {

}

Duel.select = function(el, id) {
    var jEl = $(el);
    $('span.num', jEl).remove();
    $('#duel_step_2 div.title').text(jEl.text());
    $('#DuelAnswer_question_id').val(id);
    $('#duel_step_1').hide();
    $('#duel_step_2').show();
}

Duel.submit = function(form) {
    $.post(
        $(form).attr('action'),
        $(form).serialize(),
        function(response) {
            if (response.status) {
                $('#duel_step_3').html(response.html);
                $('#duel_step_2').hide();
                $('#duel_step_3').show();
            }
        },
        'json'
    );
}