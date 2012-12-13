/**
 * Author: alexk984
 * Date: 06.12.12
 */
var CookRecipeTags = {
    setCookTag:function (recipe_id, el) {
        var tag_id = $(el).prev().val();
        $.post('/cook/recipe/addTag/', {recipe_id:recipe_id, tag_id:tag_id}, function (response) {
            if (response.status) {
                $(el).prev().prev().append('<span>'
                    + $(el).prev().find('option:selected').text() + '</span>'
                    + '<a class="remove" onclick="CookRecipeTags.removeCookTag('
                    + recipe_id + ', ' + tag_id
                    + ', this)" href="javascript:;"><i class="icon"></i></a><br>');
            }
        }, 'json');
    },
    removeCookTag:function (recipe_id, tag_id, el) {
        $.post('/cook/recipe/removeTag/', {recipe_id:recipe_id, tag_id:tag_id}, function (response) {
            if (response.status) {
                $(el).prev().remove();
                $(el).next().remove();
                $(el).remove();
            }
        }, 'json');
    }
}

$(function() {
    $('body').delegate('select[name="recipe_tag"]', 'change', function(){
        console.log('fsdh');
        $('select[name="recipe_tag"] option[value=' + $(this).val() +']').attr("selected","selected");
    });
});