var Calorisator = {

    RowI:1,
    Result:new Array(),

    // add new ingredient row

    addRow:function (event) {
        $('#ingredients tr.template').clone().insertBefore('#ingredients tr.add');
        $('.ingredient_ac').autocomplete({minLength:'2', source:'/cook/calorisator/ac/'});
        var tr = $('#ingredients tr.template').last();
        tr.find(".ingredient_ac").bind("autocompleteselect", Calorisator.acSelect);

        Calorisator.RowI++;
        tr.removeClass('template').addClass('ingredient').show();
        event.preventDefault();
    },


    // selected product from autocomplete

    acSelect:function (event, ui) {
        var tr = $(event.target).closest('tr');
        Calorisator.unitsHide(tr);
        tr.find('td.title').attr('data-id', ui.item.id);
        tr.find('td.title').attr('data-weight', ui.item.weight);
        tr.find('td.title').attr('data-density', ui.item.density);
        $.each(ui.item.nutritionals, function (index, value) {
            tr.find('.nutritional.n' + index).attr('data-value', value);
        });

        if (parseFloat(ui.item.density) > 0) {
            tr.find('td.unit select option[data-type="volume"]').show();
        }
        tr.find('td.unit select option[value="' + ui.item.unit_id + '"]').show();
        tr.find('td.unit select').val(ui.item.unit_id);

        Calorisator.Calculate();
        tr.find('td.qty input').focus();
    },


    // hide restricted units for product

    unitsHide:function (tr) {
        tr.find('td.unit select option').each(function (index, el) {
            var utype = $(el).attr('data-type');
            //if (utype != 'weight' && utype != 'volume')
            if (utype != 'weight')
                $(el).hide();
        });
    },


    // Calculate :)

    Calculate:function () {
        Results = {n1:0, n2:0, n3:0, n4:0, qty:0};

        // ingredients

        $('#ingredients tr.ingredient').each(function (trIndex, tr) {

            var unit = $(tr).find('td.unit option[value="' + $(tr).find('td.unit select').val() + '"]');
            var unit_type = unit.attr('data-type');
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
                var weight = parseFloat($(tr).find('td.title').attr('data-weight')); // weight of one piece (onlu peices units)
                qty = qty * weight;
            }

            var ratio = qty / 100;

            Results.qty += qty;

            // fill nutritional cells and add to Result
            $(tr).find('td.nutritional').each(function (tdIndex, td) {
                r = parseFloat(ratio * parseFloat($(td).attr('data-value')));
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
    }
}

$(function () {
    $('#addRow').click();
})
