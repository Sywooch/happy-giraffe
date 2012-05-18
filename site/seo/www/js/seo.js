/**
 * Author: alexk984
 * Date: 02.04.12
 * Time: 15:57
 */
var SeoModule = {
    group:new Array(),
    id:null,
    /*searchKeywords:function (term) {
        $.post('/task/searchKeywords/', {term:term}, function (response) {
            $('.keywords .result').html(response);
        });
    },*/
    addToGroup:function (el) {
        var id = this.getId($(el).parent());
        SeoModule.group.push(id);
        $('.keyword_group').append('<div>' + $(el).prev().text() + '</div>');
        $(el).parent().removeClass('default').addClass('active');
        $(el).hide();

        return false;
    },
    getId:function (el) {
        return el.attr("id").replace(/[a-zA-Z]*-/ig, "");
    },
    addGroup:function (type, author_id, rewrite) {
        var urls = new Array();
        if (rewrite == 1){
            $('.urls input').each(function(index, val){
                if ($(this).val() != '')
                    urls.push($(this).val());
            });
        }
        $.post('/task/addGroupTask/', {id:this.group,
            type:type,
            author_id:author_id,
            urls:urls,
            rewrite:rewrite
        }, function (response) {
            if (response.status) {
                $('.keyword_group').html('');
                for (var key in SeoModule.group)
                    $('#keyword-' + SeoModule.group[key]).remove();

                SeoModule.group = new Array();
            }
        }, 'json');
        return false;
    },
    setTask:function (id, type, callback) {
        $.post('/task/setTask/', {id:id, type:type}, function (response) {
            if (response.status) {
                callback();
            }
        }, 'json');
    },
    GetArticleInfo:function () {
        var url = $('input.article-url').val();
        $.post('/task/getArticleInfo/', {url:url}, function (response) {
            $('.info').html(response.title + '<br>' + response.keywords);
            SeoModule.id = response.id;
        }, 'json');
    },
    SaveArticleKeys:function () {
        var keywords = new Array();
        $('.article-keys input').each(function () {
            keywords.push($(this).val());
        });

        $.post('/task/SaveArticleKeys/', {url:$('input.article-url').val(), keywords:keywords}, function (response) {
            if (response.status){
                $('input.article-url').val('');
                $('.article-keys input').val('');
            }else{
                $.pnotify({
                    pnotify_title: 'Ошибка',
                    pnotify_type: 'error',
                    pnotify_text: response.error
                });
            }
        }, 'json');
    },
    TakeTask:function (id) {
        $.post('/task/take/', {id:id}, function (response) {
            if (response.status) {
                document.location.reload();
            }
        }, 'json');
    },
    Executed:function (id, el) {
        $.post('/task/executed/', {id:id, url:$(el).prev().val()}, function (response) {
            if (response.status) {
                document.location.reload();
            }
        }, 'json');
    },
    CloseTask:function(id){
        $.post('/task/close/', {id:id}, function (response) {
            if (response.status) {
                $('#task-'.id).remove();
                SeoModule.reloadHistory();
            }
        }, 'json');
    },
    ToPublishing:function(id){
        $.post('/task/publish/', {id:id}, function (response) {
            if (response.status) {
                SeoModule.reloadTask(id);
            }
        }, 'json');
    },
    reloadHistory:function(){

    },
    reloadTask:function(id){

    },
    hideUsed:function(el){
        $.post('/task/hideUsed/', {checked:$(el).attr('checked')}, function (response) {
        }, 'json');
    }
}