/**
 * Author: alexk984
 * Date: 21.05.12
 */
var SeoKeywords = {
    searchKeywords:function (term) {
        $('div.loading').show();
        $.post('/editor/searchKeywords/', {term:term}, function (response) {
            $('div.loading').hide();
            if (response.status) {
                $('.search .result').html(response.count);
                $('div.table-box tbody').html(response.table);
            }
            else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Не удалось получить кейворды, обратитесь к разработчику'
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
    CancelSelect:function (el) {
        var id = this.getId(el);
        $.post('/editor/CancelSelectKeyword/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').removeClass('in-buffer');
                $(el).parent('td').html('<a href="" class="icon-add" onclick="SeoKeywords.Select(this);return false;"></a><a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>');
                $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) - 1);
            }
        }, 'json');
    },
    Hide:function (el) {
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
    hideUsed:function (el) {
        $.post('/editor/hideUsed/', {checked:$(el).attr('checked')}, function (response) {
        }, 'json');
    }
}



var TaskDistribution = {
    group:new Array(),
    getId:function (el) {
        return $(el).parents('tr').attr("id").replace(/[a-zA-Z]*-/ig, "");
    },
    addToGroup:function (el) {
        var id = this.getId(el);
        TaskDistribution.group.push(id);
        console.log(TaskDistribution.group);

        $('.tasks-list').append('<div class="task-box"><a class="remove" href="" onclick="TaskDistribution.removeFromGroup(this, ' + id + ');return false; "></a><div class="drag"></div>' +
            el.parents('tr').find('.col-1 span').text() + '</div>');
        TaskDistribution.hideKeyword(id);

        $('.drag-text').hide();
        return false;
    },
    removeFromGroup:function (el, id) {
        $('#keyword-' + id).show();
        TaskDistribution.group.pop(id);
        console.log(TaskDistribution.group);
        $(el).parents('.task-box').remove();
        TaskDistribution.showKeyword(id);
    },
    removeFromSelected:function (el) {
        var id = this.getId(el);
        $.post('/editor/removeFromSelected/', {id:id}, function (response) {
            if (response.status) {
                TaskDistribution.hideKeyword(id);
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    addGroup:function (type, author_id, rewrite) {
        var urls = new Array();
        if (rewrite == 1) {
            $('.urls input').each(function (index, val) {
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
                $('.tasks-list').html('');
                $('.current-tasks tbody').append(response.html);
                TaskDistribution.group = new Array();
            }
        }, 'json');
        return false;
    },
    removeTask:function (el) {
        var id = TaskDistribution.getId(el);
        $.post('/editor/removeTask/', {id:id,withKeys:'1'}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    returnTask:function (el) {
        var id = TaskDistribution.getId(el);
        $.post('/editor/removeTask/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                for (var key in response.keys) {
                    var key_id = response.keys[key];
                    TaskDistribution.showKeyword(key_id);
                }
            }
        }, 'json');
    },
    upTask:function (el) {
        var id = TaskDistribution.getId(el);
        $.post('/editor/removeTask/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                for (var key in response.keys) {
                    var key_id = response.keys[key];
                    TaskDistribution.showKeyword(key_id);
                    $('#keyword-'+key_id+' .btn-green-small').trigger('click');
                }
            }
        }, 'json');
    },
    readyTask:function (el) {
        var id = TaskDistribution.getId(el);
        $.post('/editor/ready/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    showKeyword:function(id){
        $('#keyword-'+id).show();
        $('.default-nav .count a').text(parseInt($('.default-nav .count a').text()) + 1);
    },
    hideKeyword:function(id){
        $('#keyword-'+id).hide();
        $('.default-nav .count a').text(parseInt($('.default-nav .count a').text()) - 1);
    }
}


var SeoTasks = {
    TakeTask:function (id) {
        $.post('/task/take/', {id:id}, function (response) {
            if (response.status) {
                document.location.reload();
            }
        }, 'json');
    },
    Written:function (id, el) {
        $.post('/task/executed/', {id:id, url:$(el).prev().val()}, function (response) {
            if (response.status) {
                document.location.reload();
            }
        }, 'json');
    },
    CloseTask:function(el, id){
        $.post('/editor/close/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $('.tab-box-5 tbody').prepend(response.html);
                calcTaskCount();
            }
        }, 'json');
    },
    ToCorrection:function(el, id){
        $.post('/editor/correction/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('td').prev().removeClass('seo-status-correction-1')
                    .addClass('seo-status-correction-2').text('На коррекции');
                $(el).remove();
            }
        }, 'json');
    },
    ToPublishing:function(el, id){
        $.post('/editor/publish/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('td').prev().removeClass('seo-status-publish-1')
                    .addClass('seo-status-publish-2').text('На публикации');
                $(el).remove();
            }
        }, 'json');
    },
    Corrected:function(el, id){
        $.post('/task/corrected/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    Published:function(el, id){
        $.post('/task/executed/', {id:id, url:$(el).prev().val()}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    }
}