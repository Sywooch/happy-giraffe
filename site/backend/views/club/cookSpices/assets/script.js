var Spice = {

    acSelect:function (event, ui) {
        //console.log(ui.item);
        $('#CookSpices_ingredient_id').val(ui.item.id);
        $('#ingredient_text').text(ui.item.title).show();
        $('#ac').hide();
    },
    selectIngredient:function (event) {
        $(event.target).hide();
        $('#ac').show().focus();
        event.preventDefault();
    }


}


$(function () {
    $("#ac").bind("autocompleteselect", Spice.acSelect);
})