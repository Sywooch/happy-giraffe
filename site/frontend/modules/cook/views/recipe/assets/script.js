var CookRecipe = {

}

CookRecipe.selectServings = function(el)
{
    $('div.portions > a.active').removeClass('active');
    $(el).addClass('active');
    $('#CookRecipe_servings').val($(el).text());
}

$(function() {
    $('div.product-list').delegate('input.inAc', 'focusin', function(e) {
        $(this).autocomplete({
            minLength: 3,
            source: '/cook/recipe/ac/',
            select: function(event, ui) {
                $(this).next('input').val(ui.item.id);
                var div = $(this).parents('tr').find('div.drp-list');
                div.children('ul').html($('#unitTmpl').tmpl(ui.item.units));
                div.children('a.trigger').text(ui.item.unit.title);
                div.children('input').val(ui.item.unit.id);
            }
        });
    });

    $('div.product-list').delegate('a.trigger', 'click', function(e) {
        $(this).next('ul').toggle();
    });

    $('div.product-list').delegate('a.add-btn', 'click', function(e) {
        $('div.product-list > table').append($('#ingredientTmpl').tmpl({n: $('div.product-list tr').length}));
    });

    $('div.product-list').delegate('a.remove', 'click', function(e) {
        $(this).parents('tr').remove();
        if ($('div.product-list tr').length == 1) {
            $('div.product-list a.remove').hide();
        }
    });

    $('div.drp-list').delegate('li > a', 'click', function(e) {
        var list = $(this).parents('ul');
        list.prev('a.trigger').text($(this).text());
        list.toggle();
        list.next('input').val($(this).next('input').val());
    });

    /*$('#addRecipeForm').delegate('#CookRecipe_preparation_duration_m', 'change', function() {
        var h = $(this).parent('div.input').prev('div.input').find('input');
        if (parseInt($(this).val()) > 59) {
            h.val(Math.floor(parseInt($(this).val()) / 60) + parseInt(h.val()));
            $(this).val(parseInt($(this).val()) % 60);
        }
    });*/
});