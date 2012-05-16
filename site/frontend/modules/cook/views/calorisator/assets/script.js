var Calorisator = {

    RowI:1,
    Result:new Array(),

    addRow:function (event) {
        $('#ingredients tr.template').clone().insertBefore('#ingredients tr.results');
        $('.ingredient_ac').autocomplete({minLength:'2', source:'/cook/calorisator/ac/'});
        tr = $('#ingredients tr.template').last();
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
        tr.find('td.title').attr('data-id', ui.item.id);
        tr.find('td.title').attr('data-id', ui.item.id);
        $.each(ui.item.nutritionals, function (index, value) {
            tr.find('.nutritional.n' + index).attr('data-value', value);
        })
        tr.find('td.qty input').focus();
    },

    Calculate:function () {
        Results = {n1:0, n2:0, n3:0, n4:0, qty:0};

        // ingredients
        $('#ingredients tr.ingredient').each(function (trIndex, tr) {
            var qty = parseFloat($(tr).find('td.qty input').val());
            qty = (isNaN(qty)) ? 0 : qty;
            var ratio = qty / 100;
            Results.qty += qty;

            $(tr).find('td.nutritional').each(function (tdIndex, td) {
                r = parseFloat(ratio * parseFloat($(td).attr('data-value')));
                if (!isNaN(r) && r > 0)
                    Results['n' + $(td).attr('data-n')] += r;
                else
                    r = '';
                $(td).text(r.toFixed(2));
            });
        })

        // results
        $('#ingredients tr.results td.qty').text(Results.qty.toFixed(0));
        $('#ingredients tr.results100 td.qty').text(100);
        var ratio = Results.qty / 100;
        $('#ingredients tr.results td.nutritional').each(function (tdIndex, td) {
            r = parseFloat(Results['n' + $(td).attr('data-n')]);
            r100 = r / ratio;
            rf = r.toFixed(2);
            $(td).text(rf);

            $('#ingredients tr.results100 td.nutritional.n' + $(td).attr('data-n')).text(r100.toFixed(2));
        });
    }
}

$(function () {

    $('#addRow').click();

})
