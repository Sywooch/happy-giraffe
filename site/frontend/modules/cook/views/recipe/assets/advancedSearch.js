$(function() {
    $("#searchRecipeForm :input").change(function() {
        $.get(
            $('#searchRecipeForm').attr('action'),
            $('#searchRecipeForm').serialize(),
            function(response) {
                $('div.result').html(response);
                $('.scroll').jScrollPane({showArrows: true});
            }
        );
    });
});