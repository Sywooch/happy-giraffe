var Converter = {

    acSelect:function (event, ui) {
        var input = $('#ac');
        $.each(ui.item, function (index, value) {
            input.attr('data-' + index, value);
        });
        input.attr('data-title', ui.item.label);

        $('#ConverterForm_ingredient').val(ui.item.id);
        $('.drp-list ul li').hide();
        $.post(
            '/cook/converter/units/',
            {id:ui.item.id},
            function (data) {
                $.each(data, function (index, uid) {
                    $('.drp-list ul li[data-id="' + uid + '"]').show();
                });
            },
            'json'
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
        return false;
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

        return false;
    },

    Calculate:function () {
        if (isNaN(parseInt($('#ConverterForm_ingredient').val())))
            return false;
        if ($('#ConverterForm_qty').val() == '')
            return false;

        $('.drp-list ul').hide();
        $('#ac').val($('#ac').attr('data-title'));
        $("#converter-form").submit();
        service_used(17);
        return false;
    },

    CalculatePost:function () {
        $.post(
            $("#converter-form").attr('action'),
            $("#converter-form").serialize(),
            function (data) {
                $('.value.current').text(data);
            },
            'json'
        );
    },

    saveResult:function () {
        if ($('#ac').attr('data-title').length
            && parseFloat($('#ConverterForm_qty').val()) > 0
            && parseFloat($('span.value.current').text()) > 0
            ) {

            var hash = $('#ConverterForm_ingredient').val() + $('#ConverterForm_qty').val() + $('.trigger.from').attr('data-id') + $('.trigger.to').attr('data-id');//  + $('.trigger.from').to('data-id');

            if ($('.saved-calculations ul li[data-hash="' + hash + '"]').length == 0) {
                $('.saved-calculations ul li.template').clone().prependTo('.saved-calculations ul');
                var result = $('.saved-calculations ul li.template').first();
                result.attr('data-hash', hash);
                result.removeClass('template');
                result.find('.product-name').text($('#ac').attr('data-title'));
                result.find('.qty').text($('#ConverterForm_qty').val());
                result.find('.unit_from').text($('.trigger.from').text());
                result.find('.unit_to').text($('.trigger.to').text());
                result.find('.qty_result').text($('span.value.current').text());
                result.show();
            }
        }
    },

    clear:function () {
        $('#ac').val('').attr('data-id', '').attr('data-title', '');
        $('#ConverterForm_ingredient').val('');
        $('#ConverterForm_qty').val('');
        $('.value.current').text('');
        $('.trigger.from').attr('data-id', 1);
        $('.trigger.from').prev().val(1);
        $('.trigger.from').text('грамм');

        $('.trigger.to').attr('data-id', 1);
        $('.trigger.to').prev().val(1);
        $('.trigger.to').text('грамм');
        $('.drp-list ul li').hide();
        $('.drp-list ul').hide();
    },

    qtyInput:function (evt, elem) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
}

$(function () {
    $("#ac").bind("autocompleteselect", Converter.acSelect);
})
