var Calorisator = {

    RowI:1,
    Result:new Array(),

    // add new ingredient row

    addRow:function (event) {
        $('#ingredients tr.template').clone().insertBefore('#ingredients tr.add');

        var tr = $('#ingredients tr.template').last();

        Calorisator.RowI++;
        tr.removeClass('template').addClass('ingredient').show();
        tr.find('span.nchzn-v2').addClass('chzn-v2');
        tr.find('select.nchzn').addClass('chzn');

        $(".chzn").chosen();

        // for new rows with no product available units only gramms
        tr.find('td.unit select option').attr('style', 'display:none !important');
        tr.find('td.unit select option[value="1"]').attr('style', 'display:list-item !important');
        tr.find(".chzn").trigger("liszt:updated");

        tr.find('.ingredient_ac').autocomplete({minLength:'2', source:'/cook/calorisator/ac/'});
        tr.find(".ingredient_ac").bind("autocompleteselect", Calorisator.acSelect);
        tr.find('input[placeholder]').placeholder();

        return false;
    },

    delRow:function (target) {
        $(target).closest('tr').remove();
        Calorisator.Calculate();
        return false;
    },


    // selected product from autocomplete

    acSelect:function (event, ui) {
        var tr = $(event.target).closest('tr');
        tr.find('td.unit select option').attr('style', 'display:none !important');
        tr.find(".chzn").trigger("liszt:updated");
        tr.find('td.title').attr('data-id', ui.item.id);
        tr.find('td.title').attr('data-weight', ui.item.weight);
        tr.find('td.title').attr('data-density', ui.item.density);

        tr.find('.nutritional').attr('data-value', 0);
        $.each(ui.item.nutritionals, function (index, value) {
            tr.find('.nutritional.n' + index).attr('data-value', value);
        });

        $.each(ui.item.units, function (unit_id, weight) {
            var option = tr.find('td.unit select option[value="' + unit_id + '"]');
            option.attr('style', 'display:list-item !important');
            option.attr('data-weight', weight);
        });

        tr.find('td.unit select').val(ui.item.unit_id);
        tr.find(".chzn").trigger("liszt:updated");


        Calorisator.Calculate();
        tr.find('td.qty input').focus();
    },

    // Calculate :)

    Calculate:function () {
        var Results = {n1:0, n2:0, n3:0, n4:0, qty:0};

        // ingredients

        $('#ingredients tr.ingredient').each(function (trIndex, tr) {

            var unit = $(tr).find('td.unit option[value="' + $(tr).find('td.unit select').val() + '"]');
            var unit_type = unit.attr('data-type');
            var unit_id = unit.attr('value');
            var qty = parseFloat($(tr).find('td.qty input').val());
            qty = (isNaN(qty)) ? 0 : qty;

            if (unit_type == 'weight') {
                var unit_ratio = parseFloat(unit.attr('data-ratio'));
                qty = qty * unit_ratio;
            }
            else if (unit_type == 'volume') {
                var unit_ratio = parseFloat(unit.attr('data-ratio'));
                var density = parseFloat($(tr).find('td.title').attr('data-density'));

                if (density > 0) {
                    qty = (qty * unit_ratio) * density; // if ingredient has density convert to weight according to it
                } else {
                    qty = qty * unit_ratio; // convert as 1(ml) = 1(g)
                }
            }
            else if (unit_type == 'qty') {
                var weight = parseFloat($(tr).find('td.unit select option[value="' + unit_id + '"]').attr('data-weight'));
                qty = qty * weight;
            }

            var ratio = qty / 100;

            Results.qty += qty;

            // fill nutritional cells and add to Result
            $(tr).find('td.nutritional').each(function (tdIndex, td) {
                var r = parseFloat(ratio * parseFloat($(td).attr('data-value')));
                if (!isNaN(r) && r > 0) {
                    Results['n' + $(td).attr('data-n')] += r;
                    $(td).find('div').text(r.toFixed(2))
                }
                else {
                    $(td).find('div').html('&nbsp;');
                }
            });
        })

        // results

        $('#ingredients tr.results td.qty').text(Results.qty.toFixed(0));
        $('#ingredients tr.results100 td.qty').text(100);
        var ratio = Results.qty / 100;

        $('#ingredients tr.results td.nutritional').each(function (tdIndex, td) {
            var r = parseFloat(Results['n' + $(td).attr('data-n')]);
            var r100 = r / ratio;
            var rf = r.toFixed(2);
            $(td).text(rf);

            r100 = (isNaN(r100)) ? 0 : r100;
            $('#ingredients tr.results100 td.nutritional[data-n="' + $(td).attr('data-n') + '"]').text(r100.toFixed(2));
        });

        service_used(19);
    }
}

$(function () {
    $('#addRow').click();
})
