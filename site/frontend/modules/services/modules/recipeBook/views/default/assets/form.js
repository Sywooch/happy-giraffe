$(function() {
    $('div.product-list').delegate('input.inAc', 'focusin', function(e) {
        $(this).autocomplete({
            minLength: 3,
            source: '/recipeBook/ac/',
            select: function(event, ui) {
                $(this).next('input').val(ui.item.id);
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

    $('#addRecipeForm').delegate('#category_id', 'change', function() {
        $.ajax({
            url: '/recipeBook/diseases',
            data: {
                category_id: $(this).val()
            },
            success: function(response) {
                $('#RecipeBookRecipe_disease_id').html(response);
                $('#RecipeBookRecipe_disease_id').trigger('liszt:updated');
            }
        });
    });
});