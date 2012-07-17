var CookRecipe = {

}

CookRecipe.search = function()
{
    $.get(
        '/cook/recipe/searchByIngredientsResult/',
        $('#searchRecipeForm').serialize(),
        function(response) {
            $('div.result').html(response);
            $('select.chzn').chosen();
            $('.scroll').jScrollPane({showArrows: true});
        }
    );
}

$(function() {
    $('#searchRecipeForm').delegate('input.inAc', 'focusin', function(e) {
        $(this).autocomplete({
            minLength: 3,
            source: '/cook/recipe/ac/',
            select: function(event, ui) {
                $(this).next('input').val(ui.item.id);
                CookRecipe.search();
            }
        });
    });

    $('#searchRecipeForm').delegate('#type', 'change', function(e) {
        CookRecipe.search();
    });

    $('#searchRecipeForm').delegate('a.add-btn', 'click', function(e) {
        $('#searchRecipeForm div.ingredients ul').append($('#ingredientTmpl').tmpl());
        if ($('#searchRecipeForm div.ingredients ul > li').length >= 3)
            $('a.add-btn').hide();
    });
});