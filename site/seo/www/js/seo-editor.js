/**
 * Author: alexk984
 * Date: 21.05.12
 */
var SeoKeywords = {
    Select:function (el, short) {
        var id = this.getId(el);

        var section = '';
        if (window.content_section !== undefined)
            section = window.content_section;
        console.log(section);

        $.post('/writing/editor/selectKeyword/', {id:id,section:section}, function (response) {
            if (response.status) {
                $(el).parents('tr').addClass('in-buffer');
                if (short)
                    $(el).parent('td').html('<input type="hidden" value="' + id + '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this, ' + short + ');return false;"></a>');
                else
                    $(el).parent('td').html('в буфере <input type="hidden" value="' + id + '"><a href="" class="icon-remove" onclick="SeoKeywords.CancelSelect(this, ' + short + ');return false;"></a>');

                if (response.inc)
                    $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) + 1);
            }else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    CancelSelect:function (el, short) {
        var id = this.getId(el);
        $.post('/writing/editor/removeFromSelected/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').removeClass('in-buffer');
                if (short)
                    $(el).parent('td').html('<input type="hidden" value="' + id + '"><a href="" class="icon-add" onclick="SeoKeywords.Select(this, ' + short + ');return false;"></a>');
                else
                    $(el).parent('td').html('<input type="hidden" value="' + id + '"><a href="" class="icon-add" onclick="SeoKeywords.Select(this, ' + short + ');return false;"></a><a href="" class="icon-hat" onclick="SeoKeywords.Hide(this);return false;"></a>');

                $('.default-nav div.count a').text(parseInt($('.default-nav div.count a').text()) - 1);
            }
        }, 'json');
    },
    Hide:function (el) {
        $.post('/writing/editor/hideKey/', {id:$(el).data('id')}, function (response) {
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
    group:[],
    getId:function (el) {
        return $(el).parents('tr').data("id");
    },
    addToGroup:function (el) {
        var id = this.getId(el);
        TaskDistribution.group.push(id);

        $('.tasks-list').append('<div class="task-box"><a class="remove" href="javascript:;" onclick="TaskDistribution.removeFromGroup(this, ' + id + ')"></a><div class="drag"></div>' +
            el.parents('tr').find('.col-1 span').text() + '</div>');
        TaskDistribution.hideKeyword(id);

        $('.drag-text').hide();
        return false;
    },
    removeFromGroup:function (el, id) {
        $('#keyword-' + id).show();
        TaskDistribution.group.pop(id);
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
        var urls = [];
        if (rewrite == 1) {
            $('.urls input').each(function (index, val) {
                if ($(this).val() != '')
                    urls.push($(this).val());
            });
        }
        $.post('/writing/editor/addGroupTask/', {
            id:this.group,
            type:type,
            author_id:author_id,
            urls:urls,
            rewrite:rewrite
        }, function (response) {
            if (response.status) {
                $('.tasks-list').html('');
                $('.current-tasks tbody').append(response.html);
                TaskDistribution.group = [];
            } else
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
                console.log(response.keys);
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
        $.post('/writing/editor/ready/', {id:id,section:window.content_section}, function (response) {
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
    },
    changeSection:function(el, id, section){
        $.post('/writing/editor/changeSection/', {
            keyword_id:id,
            section:section
        }, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error'
                });
            }
        }, 'json');
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
            }else
                $.pnotify({
                    pnotify_title:response.error,
                    pnotify_type:'error'
                });
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
        $.post('/writing/corrector/corrected/', {id:id}, function (response) {
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
    page_id:null,
    keyword_id:null,
    phrase_id:null,
    AddLink:function () {
        if (!SeoLinking.checkAddLnk())
            return;

        $.post('/promotion/linking/add/', {page_id:SeoLinking.page_id, phrase_id:SeoLinking.phrase_id, keyword_id:SeoLinking.keyword_id, keyword:$('#own-keyword').val()}, function (response) {
            if (response.status) {
                $('#keyword-' + SeoLinking.keyword_id).remove();
                SeoLinking.keyword_id = null;
                $('#page-from-' + SeoLinking.page_id).remove();
                $('.step-2 ul li').removeClass('active');
                $('.table-promotion-links tr.active td b a').html(parseInt($('.table-promotion-links tr.active td b a').text()) + 1);
                $('#page-links tbody').prepend(response.linkInfo);
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    AddLinkAuto:function () {
        if (!SeoLinking.checkAddLnk())
            return;

        $('#auto-linking').fadeOut(100);

        $.post('/promotion/linking/add/', {
            page_id:SeoLinking.page_id,
            phrase_id:SeoLinking.phrase_id,
            keyword_id:SeoLinking.keyword_id,
            keyword:$('#own-keyword').val(),
            next_link:1
        }, function (response) {
            if (response.status) {

                SeoLinking.keyword_id = null;
                SeoLinking.phrase_id = response.phrase_id;
                console.log("phrase_id="+response.phrase_id);
                SeoLinking.page_id = response.page_id;
                $('#auto-linking').removeClass('loading-block').html(response.html).fadeIn(100);
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    checkAddLnk:function(){
        if (SeoLinking.keyword_id == null && $('#own-keyword').val() == '') {
            $.pnotify({
                pnotify_title:'Ошибка',
                pnotify_type:'error',
                pnotify_text:'Выберите ключевое слово'
            });
            return false;
        }
        if (SeoLinking.phrase_id == null) {
            $.pnotify({
                pnotify_title:'Ошибка',
                pnotify_type:'error',
                pnotify_text:'Выберите строку в верхней таблице'
            });
            return false;
        }
        if (SeoLinking.page_id == null) {
            $.pnotify({
                pnotify_title:'Ошибка',
                pnotify_type:'error',
                pnotify_text:'Выберите страницу с которой ставить ссылку'
            });
            return false;
        }

        return true;
    },
    removeLink:function (el, page_id, page_to_id) {
        if (confirm("Вы точно хотите удалить ссылку?")) {
            $.post('/promotion/linking/remove/', {page_id:page_id, page_to_id:page_to_id}, function (response) {
                if (response.status)
                    $(el).parents('tr').remove();
            }, 'json');
        }
    },
    selectPage:function (el, id) {
        SeoLinking.page_id = id;
        $('.step-1 ul li').removeClass('active');
        $(el).addClass('active');
    },
    selectKeyword:function (el, id) {
        if ($(el).hasClass('active')) {
            SeoLinking.keyword_id = null;
            $(el).removeClass('active');
        } else {
            SeoLinking.keyword_id = id;
            $('.step-2 ul li').removeClass('active');
            $(el).addClass('active');
        }
    },
    getPhraseData:function (el, phrase_id) {
        $('#result').addClass('loading-block');
        $.post('/promotion/linking/phraseInfo/', {phrase_id:phrase_id}, function (response) {
            $('#result').removeClass('loading-block');
            $('#result').html(response);
            $('.table-promotion-links table tr').removeClass('active');
            $(el).addClass('active');
            SeoLinking.phrase_id = phrase_id;
        });
    },
    loadStats:function (el, period, page_id) {
        if ($(el).hasClass('active'))
            return false;

        $.post('/promotion/linking/stats/', {period:period, page_id:page_id, phrase_id:SeoLinking.phrase_id}, function (response) {
            $('.table-promotion-links tbody').html(response);
            $('.table-promotion .fast-filter a').removeClass('active');
            $(el).addClass('active');
        });
    },
    showDonors:function (el, phrase_id) {
        if ($(el).text() == '0')
            return false;

        $.post('/promotion/linking/donors/', {phrase_id:phrase_id}, function (response) {
            $('#donors').html(response);
            $('#donors').show();
            var offset = $(el).offset();
            $('#donors').css('top', offset.top);
            $('#donors').css('left', offset.left - 250);
        });
    },
    showPositions:function (el, se, phrase_id) {
        $.post('/promotion/linking/positions/', {se:se, phrase_id:phrase_id}, function (response) {
            $('#positions').html(response);
            $('#positions').show();
            var offset = $(el).offset();
            $('#positions').css('top', offset.top + 20);
            $('#positions').css('left', offset.left);
        });
    },
    similarPages:function (keyword, phrase_id) {
        $('#similar-pages').addClass('loading-block');
        $.post('/promotion/linking/searchPages/', {phrase_id:phrase_id, keyword:keyword}, function (response) {
            $('#similar-pages').html(response).removeClass('loading-block');
        });
    },
    skip:function () {
        $('#auto-linking').fadeOut(100);

        $.post('/promotion/linking/skip/', {
            phrase_id:SeoLinking.phrase_id
        }, function (response) {
            if (response.status) {
                SeoLinking.keyword_id = null;
                SeoLinking.phrase_id = response.phrase_id;
                SeoLinking.page_id = response.page_id;
                $('#auto-linking').removeClass('loading-block').html(response.html).fadeIn(100);

            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    }
}

$(function () {
    $('html').click(function () {
        $('#donors').hide();
        $('#positions').hide();
    });
});