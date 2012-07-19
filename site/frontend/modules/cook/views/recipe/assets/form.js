var CookRecipe = {

}

CookRecipe.selectServings = function(el)
{
    $('div.portions > a.active').removeClass('active');
    $(el).addClass('active');
    $(el).parent().next().val($(el).text());
}

$(function() {
    $('div.product-list').delegate('input.inAc', 'focusin', function(e) {
        $(this).autocomplete({
            minLength: 3,
            source: '/cook/recipe/ac/',
            select: function(event, ui) {
                $(this).next('input').val(ui.item.id);
                var div = $(this).parents('tr').find('div.drp-list');
                div.children('ul').html($('#unitTmpl').tmpl(ui.item.units_titles));
                div.children('a.trigger').text(ui.item.unit);
                div.children('input').val(ui.item.unit_id);
            }
        });
    });

    $('div.product-list').delegate('a.trigger', 'click', function(e) {
        $('.drp-list ul').hide();
        $(this).next('ul').toggle();
    });

    $('div.product-list').delegate('a.add-btn', 'click', function(e) {
        $('div.product-list > table').append($('#ingredientTmpl').tmpl({n: $('div.product-list tr').length}));
        $('div.product-list > table tr').last().find('input[placeholder]').placeholder();
    });

    $('div.product-list').delegate('a.remove', 'click', function(e) {
        $(this).parents('tr').remove();
        if ($('div.product-list tr').length == 1) {
            $('div.product-list a.remove').hide();
        }
    });

    $('body').delegate('div.drp-list li a', 'click', function(e) {
        var list = $(this).parents('ul');
        list.prev('a.trigger').text($(this).text());
        list.toggle();
        list.next('input').val($(this).next('input').val());
    });

    $('#addRecipeForm').delegate('#CookRecipe_preparation_duration_m, #CookRecipe_cooking_duration_m', 'change', function() {
        var mEl = $(this);
        var hEl = $(this).parent().prev().find('input');
        var currentM = parseInt(mEl.val()) || 0;
        var currentH = parseInt(hEl.val()) || 0;
        if (currentM > 59) {
            mEl.val(currentM % 60);
            hEl.val(currentH + Math.floor(currentM / 60));
        }
    });
});