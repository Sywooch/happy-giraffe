/**
 * User: alexk984
 * Date: 12.04.12
 */
var Morniing = {
    editField:function (el) {
        $(el).hide();
        var name = $(el).prev().prev().hide().text();
        $(el).prev().show();
        $(el).prev().find('input').val(name);
        $(el).prev().find('textarea').val(name);
    },
    saveField:function (el, field) {
        Morniing.saveSomeField(el, field, 'CommunityContent', model_id);
    },
    saveSomeField:function (el, field, model, model_id) {
        var name = $(el).prev().val();
        $.ajax({
            url:'/ajax/setValue/',
            data:{
                entity:model,
                entity_id:model_id,
                attribute:field,
                value:name
            },
            type:'POST',
            success:function (response) {
                if (response == '1') {
                    $(el).parent().hide();
                    $(el).parent().prev().text(name).show();
                    $(el).parent().next().show();
                    $(el).parents('div.name').next().show();
                }
            },
            context:el
        });
    },
    savePos:function (el) {
        var pos = $(el).prev().val();
        $.ajax({
            url:'/morning/updatePos/',
            data:{
                id:model_id,
                pos:pos
            },
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(el).parent().hide();
                    $(el).parent().prev().text(pos).show();
                    $(el).parent().next().show();
                    $(el).parents('div.pos').next().show();
                }
            },
            context:el
        });
    },
    removePhoto:function (el) {
        $.ajax({
            url:'/morning/removePhoto/',
            data:{id:$(el).prev().val()},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(el).parent().parent().remove();
                }
            },
            context:el
        });
    },
    addPhoto:function (response) {
        //$('div.add').before(response.html);
        $.post('/morning/photo/', {id:response.id}, function (response) {
            $('div.add').before(response);
        });
    },
    removeLocation:function (el) {
        if (confirm("Удалить локацию?")) {

            $.post('/morning/removeLocation/', {id:model_id}, function (response) {
                $('#location-img').attr('src', '');
                $('#location-title').text('');
            });
        }
    }
}

$(function () {
    $('body').delegate('a.remove', 'click', function (e) {
        e.preventDefault();
        Morniing.removePhoto(this);
    });

    $('#photo_upload').iframePostForm({
        json:true,
        complete:function (response) {
            if (response.status) {
                Morniing.addPhoto(response);
            }
        }
    });

    $('.photo-file').change(function () {
        $(this).parents('form').submit();
        return false;
    });
});