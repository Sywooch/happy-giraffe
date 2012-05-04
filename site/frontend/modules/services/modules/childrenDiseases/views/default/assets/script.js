$(function () {
    $('#disease-alphabet2 a').click(function () {
        if (!$(this).hasClass('current_t')) {
            $('#category-list').hide();
            $('#alphabet-list').show();
            $('.sortable_u li').removeClass('current_t');
            $(this).parent('li').addClass('current_t');
        }
        return false;
    });

    $('#disease-type2 a').click(function () {
        if (!$(this).hasClass('current_t')) {
            $('#category-list').show();
            $('#alphabet-list').hide();
            $('.sortable_u li').removeClass('current_t');
            $(this).parent('li').addClass('current_t');
        }
        return false;
    });
});