var CookRecipe = {

}

CookRecipe.selectServings = function(el)
{
    $('div.portions > a.active').removeClass('active');
    $(el).addClass('active');
    $(el).parent().next().val($(el).text());
}

CookRecipe.selectIngredient = function (el, item)
{
    el.next('input').val(item.id);
    var div = el.parents('tr').find('div.drp-list');
    div.children('ul').html($('#unitTmpl').tmpl(item.units_titles));
    div.children('a.trigger').text(item.unit);
    div.children('input').val(item.unit_id);
}

$(function() {
    $('div.product-list').delegate('input.inAc', 'focusin', function(e) {
        $(this).data('empty', '1');
        $(this).autocomplete({
            minLength: 3,
            source: '/cook/recipe/ac/',
            select: function(event, ui) {
                $(this).data('empty', '0');
                CookRecipe.selectIngredient($(this), ui.item);
            }
        });
    });

    $('div.product-list').delegate('input.inAc', 'focusout', function(e) {
        var el = $(this);
        setTimeout(function() {
            if (el.data('empty') == 1) {
                $.get('/cook/recipe/autoSelect/', {term: el.val()}, function(response) {
                    if (response.success) {
                        CookRecipe.selectIngredient(el, response.i);
                    } else {
                        el.val('');
                    }
                }, 'json');
            }
        }, 400);
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