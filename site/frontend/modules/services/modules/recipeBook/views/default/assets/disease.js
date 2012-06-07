/**
 * Author: alexk984
 * Date: 25.04.12
 */

$(function () {
    $('.art_lk_recipes').delegate('a', 'click', function (e) {
        e.preventDefault();
        var button = $(this);
        var offer = $(this).parents('.art_lk_recipes');
        var a = {agree_u:1, disagree_u:0};
        var lol = button.parents('li').attr('class');
        var vote = a[lol];
        var offer_id = offer.attr('rel');

        $.post($('.art_lk_recipes').attr('data-url'), {id:offer_id, vote:vote}, function (response) {
            offer.find('span.votes_pro').text(response.votes_pro + ' (' + response.pro_percent + '%)');
            offer.find('span.votes_con').text(response.votes_con + ' (' + response.con_percent + '%)');
        }, 'json');
    });
});
