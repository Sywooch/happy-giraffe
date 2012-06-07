var Spice = {

    acSelect:function (event, ui) {
        //console.log(ui.item);
        $('#CookSpice_ingredient_id').val(ui.item.id);
        $('#ingredient_text').text(ui.item.title).show();
        $('#ac').hide();
    },

    selectIngredient:function (event) {
        $(event.target).hide();
        $('#ac').show().focus();
        event.preventDefault();
    },

    addHint:function () {
        $.post(
            $("#spices-hints-form").attr('action'),
            $("#spices-hints-form").serialize(),
            function (data) {
                $('#hints').html(data);
                $('#CookSpicesHints_content').val('');
            }
        );
        return false;
    },

    deleteHint:function (event) {
        $.post(
            $(event.target).attr('href'),
            function (data) {
                $('#hints').html(data);
            }
        );
        event.preventDefault();
    }
}

$(function () {
    $("#ac").bind("autocompleteselect", Spice.acSelect);

    $('#photo_upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status) {
                $('#photo-upload-block img').attr('src', response.image);
            }
        }
    });

    $('#photo_upload input').change(function(){
        $(this).parents('form').submit();
        return false;
    });

})