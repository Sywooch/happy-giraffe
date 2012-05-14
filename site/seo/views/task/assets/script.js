/**
 * Author: alexk984
 * Date: 12.05.12
 */
var SeoKeywords = {
    Select:function (el) {
        $.post('/task/selectKeyword/', {id:$(el).prev().val()}, function (response) {
            if (response.status) {
                $(el).parents('tr').addClass('used');
                $(el).remove();
                $('.selectedLink span').text(parseInt($('.selectedLink span').text()) + 1);
            }
        }, 'json');

        return false;
    }
}