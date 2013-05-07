/**
 * Author: alexk984
 * Date: 02.04.12
 * Time: 15:57
 */

$(document).ready(function () {
    $('body').delegate('a.fancy', 'click', function () {
        var onComplete_function = function () {
            if ($('.popup .chzn').size() > 0)
                $('.popup .chzn').each(function () {
                    var s = $(this);
                    s.chosen({
                        allow_single_deselect:s.hasClass('chzn-deselect')
                    });
                });
        };

        $(this).clone().fancybox({
            overlayColor:'#000',
            overlayOpacity:'0.6',
            padding:0,
            showCloseButton:false,
            scrolling:false,
            onComplete:onComplete_function
        }).trigger('click');
        return false;
    });
});

var SeoModule = {
    GetArticleInfo:function () {
        var url = $('input.article-url').val();
        $.post('/writing/task/getArticleInfo/', {url:url}, function (response) {
            $('.info').html(response.title + '<br>' + response.keywords);
            SeoModule.id = response.id;
        }, 'json');
    },
    SaveArticleKeys:function () {
        $.post('/writing/existArticles/SaveArticleKeys/', {
            url:$('input.article-url').val(),
            keywords:$('#Page_keywords').val()
        }, function (response) {
            if (response.status) {
                $('input.article-url').val('');
                $('#Page_keywords').val('');
                $('table tbody').prepend(response.html);
                $('span.articles-count').text(parseInt($('span.articles-count').text()) + 1);
                $('span.keywords-count').text(parseInt($('span.keywords-count').text()) + response.keysCount);
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    removeArticle:function (el, id) {
        $.post('/writing/existArticles/remove/', {id:id}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'статья удалена'
                });
            }
        }, 'json');
    },
    parseQueries:function () {
        $.post('/promotion/queries/parse/', function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'Спарсили ' + response.count + ' запросов',
                    pnotify_hide:false
                });
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    parseSearch:function () {
        $.post('/promotion/queries/search/', function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:response.count + ' потоков запущено',
                    pnotify_hide:false
                });
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    refreshProxy:function () {
        var proxy = $('textarea#proxy').val();
        $.post('/parsing/proxy/', {proxy:proxy}, function (response) {
            if (response.status) {
                $('textarea#proxy').val('');

                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'Новые прокси внесены в базу',
                    pnotify_hide:false
                });
            }
        }, 'json');
    },
    stopThreads:function () {
        $.post('/parsing/stopThreads/', function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'Сигнал передан, в течении минуты потоки должны завершиться',
                    pnotify_hide:false
                });
            }
        }, 'json');
    },
    setConfigAttribute:function (title, value) {
        $.post('/parsing/setConfigAttribute/', {title:title, value:value}, function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'Параметр установлен'
                });
            }
        }, 'json');
    },
    bindKeywordToArticle:function (keyword_id, entity_id, entity, el) {
        $.post('/writing/editor/bindKeywordToArticle/', {
            keyword_id:keyword_id,
            entity_id:entity_id,
            entity:entity
        }, function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'Статья привязана к ключевому слову'
                });

                $(el).addClass('active');
                $(el).parents('tr').addClass('on-site');
                $(el).parents('tr').find('td:last').html('');
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    bindKeyword:function (el, keyword_id) {
        var url = $(el).prev().val();

        $.post('/writing/editor/bindKeyword/', {
            url:url,
            keyword:keyword_id
        }, function (response) {
            if (response.status) {
                $(el).parents('tr').removeAttr('class').addClass('on-site');
                $(el).parents('td').html(response.html);
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    unbindKeyword:function (el, keyword_id) {
        $.post('/writing/editor/unbindKeyword/', {
            keyword:keyword_id
        }, function (response) {
            if (response.status) {
                $(el).parents('tr').removeAttr('class');
                $(el).parents('td').html(response.html);
            } else {
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
            }
        }, 'json');
    },
    removeUser:function (list_name, entity_id, el) {
        $.post('/site/removeUser/', {list_name:list_name, entity_id:entity_id}, function (response) {
            if (response.status) {
                $(el).parents('li').remove();
            }
        }, 'json');
    }
};

var Indexing = {
    showRemoveUrls:function () {
        $('#add-urls').hide();
        $('#remove-urls').show();
    },
    showAddUrls:function () {
        $('#add-urls').show();
        $('#remove-urls').hide();
    }
}

var Advert = {
    close:function () {
        $.post('/site/closeAdvert/', function (response) {
            $('div.advert').remove();
        });
    }
}