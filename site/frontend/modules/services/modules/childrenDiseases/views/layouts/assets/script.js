$(function () {

    $('#disease-alphabet').click(function () {
        if ($(this).parent('li').hasClass('current_t')) {
            $('#popup').hide();
            $(this).parent('li').removeClass('current_t');
        } else {
            $(this).parent('li').addClass('current_t');
            $('#disease-type').parent('li').removeClass('current_t');

            $.ajax({
                url:'/childrenDiseases/getAlphabetList/',
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

    $('#disease-type').click(function () {
        if ($(this).parent('li').hasClass('current_t')) {
            $('#popup').hide();
            $(this).parent('li').removeClass('current_t');
        } else {
            $(this).parent('li').addClass('current_t');
            $('#disease-alphabet').parent('li').removeClass('current_t');
            $.ajax({
                url:'/childrenDiseases/getCategoryList/',
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
});
