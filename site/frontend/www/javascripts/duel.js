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

Duel.vote = function(el, id) {
    $.post(
        '/ajax/duelVote/',
        {id: id},
        function(response) {
            if (response) {
                $(el).before('<span>Мой голос</span><br />');
                var vote = $(el).parents('div.vote');
                var counter = $('span.count-in', vote);
                $('div.vote div.button a').addClass('active');
                $('div.vote div.button a').attr('disabled', 'disabled');
                $('div.vote div.button a').removeAttr('href');
                $('div.vote div.button a').removeAttr('onclick')
                counter.text(parseInt(counter.text()) + 1);
            }
        }
    );
}

Duel.showVotes = function() {
    $('#duel-votes').slideToggle();
}