var Converter = {

    Errors:new Array(),

    acSelect:function (event, ui) {
        var input = $('#ac');

        // set ingredient info as input attributes
        $.each(ui.item, function (index, value) {
            input.attr('data-' + index, value);
        });
        $('#ConverterForm_ingredient').val(ui.item.id);

        // set convert directions
        $('#ConverterForm_from option, #ConverterForm_to option').hide();
        $('#ConverterForm_from option[data-type="weight"], #ConverterForm_to option[data-type="weight"]').show();
        $('#ConverterForm_from, #ConverterForm_to').val(1);

        if (ui.item.weight > 0) {
            $('#ConverterForm_from').val(ui.item.unit_id);
            $('#ConverterForm_from option[data-id="' + ui.item.unit_id + '"], #ConverterForm_to option[data-id="' + ui.item.unit_id + '"]').show();
        }

        if (ui.item.density > 0) {
            $('#ConverterForm_from option[data-type="volume"], #ConverterForm_to option[data-type="volume"]').show();
        }


    },

    Calculate:function () {
        $('#ac').val($('#ac').attr('data-title'));

        $.post(
            $("#converter-form").attr('action'),
            $("#converter-form").serialize(),
            function (data) {
                $('#result').html(data);
            }
        );

        return false;
    }
}

$(function () {
    $("#ac").bind("autocompleteselect", Converter.acSelect);
})
