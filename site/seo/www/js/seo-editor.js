/**
 * Author: alexk984
 * Date: 21.05.12
 */
var SeoKeywords = {
    searchKeywords:function (term) {
        $('div.loading').show();
        $.post('/task/searchKeywords/', {term:term}, function (response) {
            $('div.loading').hide();
            if (response.status){
                $('.search .result').html(response.count);
                $('div.table-box tbody').html(response.table);
            }
            else{
                $.pnotify({
                    pnotify_title: 'Ошибка',
                    pnotify_type: 'error',
                    pnotify_text: 'Не удалось получить кейворды, обратитесь к разработчику'
                });
            }
        }, 'json');
    },
    Select:function (el) {
        var id = $(el).parents('tr').attr("id").replace(/[a-zA-Z]*-/ig, "");
        $.post('/task/selectKeyword/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').addClass('in-buffer');
                $(el).parent('td').html("in-buffer");
                $('.selectedLink span').text(parseInt($('.selectedLink span').text()) + 1);
            }
        }, 'json');
    },
    Hide:function(el){

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
    hideUsed:function(el){
        $.post('/task/hideUsed/', {checked:$(el).attr('checked')}, function (response) {
        }, 'json');
    }
}