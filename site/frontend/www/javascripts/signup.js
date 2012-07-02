$(document).ready(function () {
    $('#next_1').click(function () {
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/signup/validate/step/1/',
            data:$('#signup').serialize(),
            success:function (response) {
                if (response.status == 'ok') {
                    $('#step_1 .errors').html('');
                    $('#step_1').hide();
                    $('#step_2').show();
                    $('.steps li.active').removeClass('active');
                    $('.steps li:nth-child(2)').addClass('active');
                    $('div.title').hide();
                    $('div.header > div.login-link').hide();
                }
                else {
                    $('#step_1 .errors').html(response.errors);
                }
            }
        });
        return false;
    });

    $('#next_2').click(function () {
        $.ajax({
            type:'POST',
            dataType:'json',
            url:'/signup/validate/step/1/',
            data:$('#signup').serialize(),
            success:function (response) {
                if (response.status == 'ok') {
                    $('#step_2 .errors').html('');
                    $('#signup').submit();
                } else {
                    $('#step_2 .errors').html(response.errors);
                }
            }
        });
        return false;
    });

    $('.inc').click(function () {
        var input = $(this).prev();
        var old_val = parseInt(input.val());
        input.val(old_val + 1);
    });
    $('.dec').click(function () {
        var input = $(this).next();
        var old_val = parseInt(input.val());
        if (old_val > 0) input.val(parseInt(input.val()) - 1);
    });
    $('#agree').change(function () {
        $('#next_2').toggleClass('disabled').toggleDisabled();
    });
});

function choose(val) {
    $('#User_gender').val(val);
    $('.gender-select li.active').removeClass('active');
    $('.gender-select li:nth-child(' + (val + 1) + ')').addClass('active');
}


var SignUp = {
    send:function () {
        $.post('singup2/finish', $('#singup-form').serialize(), function (response) {
            if (response.status) {

            }
        }, 'json');
    }
}