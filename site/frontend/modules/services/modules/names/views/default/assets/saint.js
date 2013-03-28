/**
 * Author: alexk984
 * Date: 25.04.12
 */
var gender;
var month;

$(function () {
    $('ul.letters a').click(function () {
        month = $('ul.month li a').index($(this)) + 1;

        if (typeof(window.history.pushState) == 'function') {
            window.history.pushState({ path:$(this).attr('href') }, 'Святцы в ' + $(this).text(),
                $(this).attr('href'));
        } else {
            return true;
        }

        $.ajax({
            url:'/names/saint/',
            data:{
                month:month,
                gender:gender
            },
            type:'GET',
            dataType:'JSON',
            success:function (data) {
                $('ul.letters li').removeClass('active');
                $(this).parent('li').addClass('active');
                $('#result').html(data.html);
                $('p.names_header').html('Имена по святцам - <span>' + data.month + '</span>');
            },
            context:$(this)
        });
        return false;
    });

    $('.gender-link a').click(function () {
        gender = $(this).attr('rel');

        $.ajax({
            url:'/names/saint/',
            data:{
                month:month,
                gender:gender
            },
            type:'GET',
            dataType:'JSON',
            success:function (data) {
                $('.gender-link a').removeClass('active');
                $(this).addClass('active');
                $('#result').html(data.html);
            },
            context:$(this)
        });
        return false;
    });

    $(window).bind('popstate', function (event) {
        var state = event.originalEvent.state;
        if (state) {
            gender = $(this).attr('rel');
            $.ajax({
                url:state.path,
                type:'GET',
                dataType:'JSON',
                success:function (data) {
                    $('.gender-link a').removeClass('active');
                    $('.all_names').addClass('active');
                    $('#result').html(data.html);
                    $('ul.letters li').removeClass('active');
                    if (data.month == null) {
                        $('p.names_header').html('Имена по святцам');
                    } else {
                        $('p.names_header').html('Имена по святцам - <span>' + data.month + '</span>');
                        $('ul.letters li:eq(' + (data.month_num - 1) + ')').addClass('active');
                    }
                    month = data.month_num;
                },
                context:$(this)
            });
        }
    });

    history.replaceState({ path:window.location.href }, '');
});