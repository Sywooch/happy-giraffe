var Nutritionals = {

    // create nutritional
    Link:function () {
        $.post(
            $("#cook-ingredients-nutritionals-create-form").attr('action'),
            $("#cook-ingredients-nutritionals-create-form").serialize(),
            function (data) {
                $('#nutritionals').html(data);
            }
        );
        return false;
    },

    // create synonym
    createSynonym:function () {
        $.post(
            $("#cook-ingredients-synonyms-create-form").attr('action'),
            $("#cook-ingredients-synonyms-create-form").serialize(),
            function (data) {
                $('#synonyms').html(data);
            }
        );
        return false;
    },

    // delete synonyms, nutritionals

    deleteChild:function (event, container) {
        var link = $(event.target);
        if (confirm('Удалить?')) {
            $.post(link.attr('href'), function (data) {
                $('#' + container).html(data);
            })
        }
        event.preventDefault();
    }

}

var Units = {

    save:function (event) {
        $.post(
            $('#ingredientUnits').attr('action'),
            $('#ingredientUnits').serializeArray(),
            function (data) {
                $('#units-container').html(data.html);
                $.pnotify({pnotify_title:'Единицы измерения', pnotify_text:data.error});
            }
        );
        event.preventDefault()
    }
}