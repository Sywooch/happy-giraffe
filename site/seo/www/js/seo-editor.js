/**
 * Author: alexk984
 * Date: 21.05.12
 */
var SeoKeywords = {
    page : 0,
    term : '',
    searchKeywords:function () {
        $('div.loading').show();
        $.post('/writing/editor/searchKeywords/', {term:this.term, page:this.page}, function (response) {
            $('div.loading').hide();
            if (response.status) {
                $('.search .result').html(response.count);
                $('div.table-box tbody').html(response.table);
                $('div.pagination').html(response.pagination);
                $('html,body').animate({scrollTop: $('html').offset().top},'fast');
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
    Select:function (el, short) {
        var id = this.getId(el);
        $.post('/writing/editor/selectKeyword/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').addClass('in-buffer');
                if (short)
                    $(el).parent('td').html('<input type="hidden" value="' + id + '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this, '+short+');return false;"></a>');
                else
                    $(el).parent('td').html('в буфере <input type="hidden" value="' + id + '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this, '+short+');return false;"></a>');
                $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) + 1);
            }
        }, 'json');
    },
    CancelSelect:function (el, short) {
        var id = this.getId(el);
        $.post('/writing/editor/CancelSelectKeyword/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').removeClass('in-buffer');
                if (short)
                    $(el).parent('td').html('<input type="hidden" value="' + id + '"><a href="" class="icon-add" onclick="SeoKeywords.Select(this, '+short+');return false;"></a>');
                else
                    $(el).parent('td').html('<input type="hidden" value="' + id + '"><a href="" class="icon-add" onclick="SeoKeywords.Select(this, '+short+');return false;"></a><a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>');

                $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) - 1);
            }
        }, 'json');
    },
    Hide:function (el) {
        var id = this.getId(el);
        $.post('/writing/editor/hideKey/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    getId:function (el) {
        return $(el).parent('td').find("input").val();
    },
    hideUsed:function (el, callback) {
        $.post('/writing/editor/hideUsed/', {checked:$(el).attr('checked')}, function (response) {
            callback();
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
//        console.log(TaskDistribution.group);

        $('.tasks-list').append('<div class="task-box"><a class="remove" href="" onclick="TaskDistribution.removeFromGroup(this, ' + id + ');return false; "></a><div class="drag"></div>' +
            el.parents('tr').find('.col-1 span').text() + '</div>');
        TaskDistribution.hideKeyword(id);

        $('.drag-text').hide();
        return false;
    },
    removeFromGroup:function (el, id) {
        $('#keyword-' + id).show();
        TaskDistribution.group.pop(id);
//        console.log(TaskDistribution.group);
        $(el).parents('.task-box').remove();
        TaskDistribution.showKeyword(id);
    },
    removeFromSelected:function (el) {
        var id = this.getId(el);
        $.post('/writing/editor/removeFromSelected/', {id:id}, function (response) {
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
        $.post('/writing/editor/addGroupTask/', {id:this.group,
            type:type,
            author_id:author_id,
            urls:urls,
            rewrite:rewrite
        }, function (response) {
            if (response.status) {
                $('.tasks-list').html('');
                $('.current-tasks tbody').append(response.html);
                TaskDistribution.group = new Array();
            }else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });

        }, 'json');
        return false;
    },
    removeTask:function (el) {
        var id = TaskDistribution.getId(el);
        $.post('/writing/editor/removeTask/', {id:id, withKeys:'1'}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    returnTask:function (el) {
        var id = TaskDistribution.getId(el);
        $.post('/writing/editor/removeTask/', {id:id}, function (response) {
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
        $.post('/writing/editor/removeTask/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                for (var key in response.keys) {
                    var key_id = response.keys[key];
                    TaskDistribution.showKeyword(key_id);
                    $('#keyword-' + key_id + ' .btn-green-small').trigger('click');
                }
            }
        }, 'json');
    },
    readyTask:function (el) {
        var id = TaskDistribution.getId(el);
        $.post('/writing/editor/ready/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    showKeyword:function (id) {
        $('#keyword-' + id).show();
        $('.default-nav .count a').text(parseInt($('.default-nav .count a').text()) + 1);
    },
    hideKeyword:function (id) {
        $('#keyword-' + id).hide();
        $('.default-nav .count a').text(parseInt($('.default-nav .count a').text()) - 1);
    }
}


var SeoTasks = {
    TakeTask:function (id) {
        $.post('/writing/task/take/', {id:id}, function (response) {
            if (response.status) {
                document.location.reload();
            }
        }, 'json');
    },
    Written:function (id, el) {
        $.post('/writing/task/executed/', {id:id, url:$(el).prev().val()}, function (response) {
            if (response.status) {
                document.location.reload();
            }
        }, 'json');
    },
    CloseTask:function (el, id) {
        $.post('/writing/editor/close/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $('.tab-box-5 tbody').prepend(response.html);
                calcTaskCount();
            }
        }, 'json');
    },
    ToCorrection:function (el, id) {
        $.post('/writing/editor/correction/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('td').prev().removeClass('seo-status-correction-1')
                    .addClass('seo-status-correction-2').text('На коррекции');
                $(el).remove();
            }
        }, 'json');
    },
    ToPublishing:function (el, id) {
        $.post('/writing/editor/publish/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('td').prev().removeClass('seo-status-publish-1')
                    .addClass('seo-status-publish-2').text('На публикации');
                $(el).remove();
            }
        }, 'json');
    },
    Corrected:function (el, id) {
        $.post('/writing/task/corrected/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            }
        }, 'json');
    },
    Published:function (el, id) {
        if ($(el).prev().val() !== "")
            $.post('/writing/task/executed/', {id:id, url:$(el).prev().val()}, function (response) {
                if (response.status) {
                    $(el).parents('tr').remove();
                } else {
                    if (response.errorText !== undefined)
                        $.pnotify({
                            pnotify_title:'Ошибка',
                            pnotify_type:'error',
                            pnotify_text:response.errorText
                        });
                    else
                        $.pnotify({
                            pnotify_title:'Ошибка',
                            pnotify_type:'error',
                            pnotify_text:response.error
                        });
                }
            }, 'json');
        else
            $.pnotify({
                pnotify_title:'Ошибка',
                pnotify_type:'error',
                pnotify_text:'Введите url статьи'
            });
    }
}

var SeoLinking = {
    keywordId:null,
    Go:function (el) {
        var url = $(el).prev().val();
        SeoLinking.keywordId = null;

        $.post('/linking/go/', {url:url}, function (response) {
            if (response.status) {
                $('.result').html(response.html);
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    AddLink:function (el, linkingPageId, articleId) {
        if (SeoLinking.keywordId == null) {
            $.pnotify({
                pnotify_title:'Ошибка',
                pnotify_type:'error',
                pnotify_text:'Выберите ключевое слово'
            });
        } else
            $.post('/linking/add/', {id:linkingPageId, articleFromId:articleId, keyword_id:SeoLinking.keywordId}, function (response) {
                if (response.status) {
                    $(el).remove();
                    $('#keyword-' + SeoLinking.keywordId).remove();
                    SeoLinking.keywordId = null;
                } else {
                    $.pnotify({
                        pnotify_title:'Ошибка',
                        pnotify_type:'error',
                        pnotify_text:response.error
                    });
                }
            }, 'json');
    },
    CheckKeyword:function (el, keywordId) {
        SeoLinking.keywordId = keywordId;
        $('a.keyword-for-link').removeClass('active');
        $(el).addClass('active');
    }
}