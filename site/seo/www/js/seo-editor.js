/**
 * Author: alexk984
 * Date: 21.05.12
 */
var SeoKeywords = {
    searchKeywords:function (term) {
        $('div.loading').show();
        $.post('/editor/searchKeywords/', {term:term}, function (response) {
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
        var id = this.getId(el);
        $.post('/editor/selectKeyword/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').addClass('in-buffer');
                $(el).parent('td').html('in-buffer <a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this);return false;"></a>');
                $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) + 1);
            }
        }, 'json');
    },
    CancelSelect:function(el){
        var id = this.getId(el);
        $.post('/editor/CancelSelectKeyword/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').removeClass('in-buffer');
                $(el).parent('td').html('<a href="" class="icon-add" onclick="SeoKeywords.Select(this);return false;"></a><a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>');
                $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) - 1);
            }
        }, 'json');
    },
    Hide:function(el){
        var id = this.getId(el);
        $.post('/editor/hideKey/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    getId:function (el) {
        return $(el).parents('tr').attr("id").replace(/[a-zA-Z]*-/ig, "");
    },
    addGroup:function (type, author_id, rewrite) {
        var urls = new Array();
        if (rewrite == 1){
            $('.urls input').each(function(index, val){
                if ($(this).val() != '')
                    urls.push($(this).val());
            });
        }
        $.post('/editor/addGroupTask/', {id:this.group,
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
        $.post('/editor/setTask/', {id:id, type:type}, function (response) {
            if (response.status) {
                callback();
            }
        }, 'json');
    },
    hideUsed:function(el){
        $.post('/editor/hideUsed/', {checked:$(el).attr('checked')}, function (response) {
        }, 'json');
    }
}