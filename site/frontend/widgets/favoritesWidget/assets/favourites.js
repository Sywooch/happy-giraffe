/**
 * Author: alexk984
 * Date: 10.04.12
 * Time: 13:23
 */
var Favourites = {
    toggle:function (el, num) {
        var entity = $(el).parent('div').find('input.entity').val();
        var entity_id = $(el).parent('div').find('input.entity_id').val();

        $.post('/ajax/toggleFavourites/', {entity:entity, entity_id:entity_id, num:num}, function (response) {
            if (response.status) {
                $(el).toggleClass('active');
                if ($(el).attr('title') == '') $(el).attr('title', '');

            }
        }, 'json');
    }
}