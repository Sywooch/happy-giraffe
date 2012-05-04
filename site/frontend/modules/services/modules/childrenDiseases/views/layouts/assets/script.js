var still_out = true;
var closetimer;

$(function () {

    $('#disease-alphabet').mouseover(function () {
        if ($(this).parent('li').hasClass('current_t')) {
            still_out = false;
        } else {
            $(this).parent('li').addClass('current_t');
            $('#disease-type').parent('li').removeClass('current_t');

            $.ajax({
                url:$('#disease-alphabet2 a').attr('href'),
                type:'POST',
                success:function (data) {
                    $('#popup').html(data);
                    $('#popup').show();

                },
                context:$(this)
            });
        }
        return false;
    });

    $('#disease-type').mouseover(function () {
        if ($(this).parent('li').hasClass('current_t')) {
            still_out = false;
        } else {
            $(this).parent('li').addClass('current_t');
            $('#disease-alphabet').parent('li').removeClass('current_t');
            $.ajax({
                url:$('#disease-type2 a').attr('href'),
                type:'POST',
                success:function (data) {
                    $('#popup').html(data);
                    $('#popup').show();

                },
                context:$(this)
            });
        }
        return false;
    });

    $('html').click(function () {
        $('#popup').hide();
        $('#disease-alphabet').parent('li').removeClass('current_t');
        $('#disease-type').parent('li').removeClass('current_t');
    });

    $('#popup').click(function (event) {
        event.stopPropagation();
    });
    $('#popup').click(function (event) {
        event.stopPropagation();
    });

    $('#popup').bind('mouseleave', function () {
        still_out = true;
        closetimer = window.setTimeout(popup_close, 500);
    });

    $('#popup').bind('mouseover', function () {
        still_out = false;
    });

    $('#disease-alphabet').bind('mouseleave', function () {
        if ($(this).parent('li').hasClass('current_t')) {
            still_out = true;
            closetimer = window.setTimeout(popup_close, 500);
        }
    });
    $('#disease-type').bind('mouseleave', function () {
        if ($(this).parent('li').hasClass('current_t')) {
            still_out = true;
            closetimer = window.setTimeout(popup_close, 500);
        }
    });
});

function popup_close() {
    if (still_out) {
        $('#popup').hide();
        $('#disease-alphabet').parent('li').removeClass('current_t');
        $('#disease-type').parent('li').removeClass('current_t');
        clearTimeout(closetimer);
    }
}