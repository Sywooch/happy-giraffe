/**
 * Author: alexk984
 * Date: 25.04.12
 */
var gender;
var page;
var title;

$(function () {

    $('ul.letters a').click(function () {
        letter = $(this).text();
        url = $(this).attr('href');
        title = 'Имена на букву ' + letter;
        if (letter == 'Все') {
            letter = null;
            title = 'Все имена'
        }

        if (typeof(window.history.pushState) == 'function') {
            window.history.pushState(
                { path:$(this).attr('href'), letter:letter },
                title,
                $(this).attr('href')
            );
        } else {
            return true;
        }

        $.ajax({
            url:'/names/',
            data:{
                letter:letter,
                gender:gender
            },
            type:'GET',
            success:function (data) {
                $('ul.letters li').removeClass('active');
                if ($(this).text() == 'Все')
                    $('p.names_header').html('Все имена');
                else
                    $('p.names_header').html('Имена на букву <span>' + $(this).text() + '</span>');
                $(this).parent('li').addClass('active');
                $('#result').html(data);
            },
            context:$(this)
        });
        return false;
    });

    $('.gender-link a').click(function () {
        gender = $(this).attr('rel');

        $.ajax({
            url:'/names/',
            data:{
                letter:letter,
                gender:gender
            },
            type:'GET',
            success:function (data) {
                $('.gender-link a').removeClass('active');
                $(this).addClass('active');
                $('#result').html(data);
            },
            context:$(this)
        });
        return false;
    });

    $('body').delegate('.pagination a', 'click', function () {
        $.ajax({
            url:$(this).attr('href'),
            data:{
                letter:letter,
                gender:gender
            },
            type:'GET',
            success:function (data) {
                $('#result').html(data);
                $('html,body').animate({scrollTop:$('ul.letters').offset().top}, 'fast');
            }
        });

        return false;
    });

    $(window).bind('popstate', function (event) {
        var state = event.originalEvent.state;
        letter = state.letter;

        if (state) {
            $.ajax({
                url:$('.choice_name_navi li:first a').attr('href'),
                data:{
                    letter:letter,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('ul.letters li').removeClass('active');

                    if (state.letter == null) {
                        $('p.names_header').html('Все имена');
                        $('ul.letters li:first').addClass('active');
                        letter = null;
                    }
                    else {
                        $('p.names_header').html('Имена на букву <span>' + state.letter + '</span>');
                        letter = state.letter;
                    }
                    $('ul.letters li').each(function (index, value) {
                        if ($(this).text() == state.letter)
                            $(this).addClass('active');
                    });
                    $('#result').html(data);
                },
                context:$(this)
            });
        }
    });
});