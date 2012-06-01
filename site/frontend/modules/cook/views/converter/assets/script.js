var Converter = {

    acSelect:function (event, ui) {
        var input = $('#ac');
        $.each(ui.item, function (index, value) {
            input.attr('data-' + index, value);
        });

        $('#ConverterForm_ingredient').val(ui.item.id);
        $('.drp-list ul li').hide();
        $.post(
            '/cook/converter/units/',
            {id:ui.item.id},
            function (data) {
                $.each(data, function (index, uid) {
                    $('.drp-list ul li[data-id="' + uid + '"]').show();
                });
            }
        );

        $('.trigger.from').attr('data-id', ui.item.unit_id);
        $('.trigger.from').prev().val(ui.item.unit_id);
        $('.trigger.from').text($('.drp-list.from ul li[data-id="' + ui.item.unit_id + '"]').text());

        Converter.Calculate();
    },

    unitSelect:function (el, event) {
        $('.drp-list ul').hide();
        el.closest('.drp-list').find('a.trigger').text(el.text()).attr('data-id', el.parent().attr('data-id'));
        el.closest('.drp-list').find('input').val(el.parent().attr('data-id'));

        Converter.Calculate();
        event.preventDefault();
    },

    unitSwap:function (event) {
        var from_id = $('.trigger.from').attr('data-id');
        var to_id = $('.trigger.to').attr('data-id');

        $('.trigger.from').attr('data-id', to_id);
        $('.trigger.from').prev().val(to_id);
        $('.trigger.from').text($('.drp-list.from ul li[data-id="' + to_id + '"]').text());

        $('.trigger.to').attr('data-id', from_id);
        $('.trigger.to').prev().val(from_id);
        $('.trigger.to').text($('.drp-list.from ul li[data-id="' + from_id + '"]').text());

        Converter.Calculate();

        event.preventDefault();
    },

    Calculate:function () {
        $('#ac').val($('#ac').attr('data-title'));
        $.post(
            $("#converter-form").attr('action'),
            $("#converter-form").serialize(),
            function (data) {
                $('.value.current').text(data);
            }
        );

        return false;
    }
}

$(function () {
    $("#ac").bind("autocompleteselect", Converter.acSelect);
})
