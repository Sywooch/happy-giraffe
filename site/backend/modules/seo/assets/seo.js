/**
 * Author: alexk984
 * Date: 02.04.12
 * Time: 15:57
 */
var SeoModule = {
    group:new Array(),
    id:null,
    searchKeywords:function (term) {
        $.post('/seo/task/searchKeywords', {term:term}, function (response) {
            $('.keywords .result').html(response);
            SeoModule.refreshKeywordsDrag();
        });
    },
    refreshKeywordsDrag:function () {
        $('div.keywords ul li').draggable("destroy");
        $('div.keywords ul li.default').draggable({handle:'.drag', revert:true, revertDuration:100});
    },
    dropToGroup:function (event, ui) {
        var id = SeoModule.getId(ui.draggable);
        SeoModule.group.push(id);
        $('.keyword_group').append('<div>' + ui.draggable.text() + '</div>');
        $('#key-' + id).removeClass('default').addClass('active');
        SeoModule.refreshKeywordsDrag();
    },
    dropToTask:function (event, ui) {
        var id = SeoModule.getId(ui.draggable);
        $.post('/seo/task/addTask', {id:id}, function (response) {
            if (response.status) {
                $('div.tasks').html(response.html);
                $('#key-' + id).removeClass('default').addClass('active');
                SeoModule.refreshKeywordsDrag();
            }
            else
                return false;
        }, 'json');
    },
    getId:function (el) {
        return el.attr("id").replace(/[a-zA-Z]*-/ig, "");
    },
    addGroup:function () {
        $.post('/seo/task/addGroupTask', {id:this.group}, function (response) {
            if (response.status) {
                $('div.tasks').html(response.html);
                $('.keyword_group').html('');
            }
            else
                return false;
        }, 'json');
    },
    toEditor:function (el) {
        this.setTask(this.getId($(el).parent()), 2, function () {
            $(el).parent().remove();
        });
    },
    toModer:function (el) {
        this.setTask(this.getId($(el).parent()), 2, function () {
            $(el).parent().remove();
        });
    },
    setTask:function (id, type, callback) {
        $.post('/seo/task/setTask', {id:id, type:type}, function (response) {
            if (response.status) {
                callback();
            }
        }, 'json');
    },
    GetArticleInfo:function () {
        var url = $('input.article-url').val();
        $.post('/seo/task/getArticleInfo', {url:url}, function (response) {
            $('.info').html(response.title+'<br>'+response.keywords);
            SeoModule.id = response.id;
        }, 'json');
    },
    SaveArticleKeys:function () {
        var keywords = new Array();
        $('.article-keys input').each(function () {
            keywords.push($(this).val());
        });

        $.post('/seo/task/SaveArticleKeys', {id:this.id, keywords:keywords}, function (response) {

        }, 'json');
    }
}