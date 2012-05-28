var Calorisator = {

    RowI:1,
    Result:new Array(),

    addRow:function (event) {
        $('#ingredients tr.template').clone().insertBefore('#ingredients tr.results');
        $('.ingredient_ac').autocomplete({minLength:'2', source:'/cook/calorisator/ac/'});
        var tr = $('#ingredients tr.template').last();
        tr.find(".ingredient_ac").bind("autocompleteselect", Calorisator.acSelect);
        tr.find('input').each(function (index, el) {
            $(el).attr('name', $(el).attr('name').replace('nnn', Calorisator.RowI));
            $(el).attr('id', $(el).attr('id').replace('nnn', Calorisator.RowI));
        })
        Calorisator.RowI++;
        tr.removeClass('template').addClass('ingredient').show();
        event.preventDefault();
    },

    acSelect:function (event, ui) {
        var tr = $(event.target).closest('tr');
        Calorisator.unitsHide(tr);
        tr.find('td.title').attr('data-id', ui.item.id);
        tr.find('td.title').attr('data-weight', ui.item.weight);
        $.each(ui.item.nutritionals, function (index, value) {
            tr.find('.nutritional.n' + index).attr('data-value', value);
        });

        tr.find('td.unit select option[value="' + ui.item.unit_id + '"]').show();
        tr.find('td.unit select').val(ui.item.unit_id);


        Calorisator.Calculate();
        tr.find('td.qty input').focus();
    },

    unitsHide:function (tr) {
        tr.find('td.unit select option').each(function (index, el) {
            var utype = $(el).attr('data-type');
            if (utype != 'weight' && utype != 'volume')
                $(el).hide();
        });
    },

    Calculate:function () {
        Results = {n1:0, n2:0, n3:0, n4:0, qty:0};

        // ingredients

        $('#ingredients tr.ingredient').each(function (trIndex, tr) {

            var unit_ratio = parseFloat($(tr).find('td.unit option[value="' + $(tr).find('td.unit select').val() + '"]').attr('data-ratio')); // ratio for weight/volume units
            var weight = parseFloat($(tr).find('td.title').attr('data-weight')); // weight of one piece (onlu peices units)

            var qty = parseFloat($(tr).find('td.qty input').val());
            qty = (isNaN(qty)) ? 0 : qty;
            if (weight > 0) {
                qty = qty * weight;
            } else {
                qty = qty * unit_ratio;
            }

            var ratio = qty / 100;
            Results.qty += qty;

            // fill nutritional cells and add to Result
            $(tr).find('td.nutritional').each(function (tdIndex, td) {
                r = parseFloat(ratio * parseFloat($(td).attr('data-value')));
                if (!isNaN(r) && r > 0) {
                    Results['n' + $(td).attr('data-n')] += r;
                    $(td).text(r.toFixed(2));
                }
                else {
                    $(td).text('');
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
            $('#ingredients tr.results100 td.nutritional.n' + $(td).attr('data-n')).text(r100.toFixed(2));
        });
    }
}

$(function () {

    $('#addRow').click();

})
