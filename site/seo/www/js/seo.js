/**
 * Author: alexk984
 * Date: 02.04.12
 * Time: 15:57
 */
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
            keywords:$('#ArticleKeywords_keywords').val()
        }, function (response) {
            if (response.status) {
                $('input.article-url').val('');
                $('#ArticleKeywords_keywords').val('');
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
        $.post('/queries/parse/', function (response) {
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
        $.post('/queries/search/', function (response) {
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
        $.post('/queries/proxy/', {proxy:proxy}, function (response) {
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
        $.post('/queries/stopThreads/', function (response) {
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
        $.post('/queries/setConfigAttribute/', {title:title, value:value}, function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'Параметр установлен'
                });
            }
        }, 'json');
    }
}

var WordStat = {
    addKeyword:function (el) {
        $.post('/wordstat/addKeywords/', {keyword:$(el).prev().val()}, function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:response.count + ' слов добавлено на парсинг',
                    pnotify_hide:false
                });
            }
        }, 'json');
    },
    addCompetitors:function () {
        $.post('/wordstat/addCompetitors/', function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:response.count + ' слов добавлено на парсинг',
                    pnotify_hide:false
                });
            }
        }, 'json');
    },
    clearKeywords:function () {
        $.post('/wordstat/clearParsingKeywords/', function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:'',
                });
            }
        }, 'json');
    }
}

var Competitors = {
    Parse:function (mode) {
        $.post('/competitors/parse/parse/', {
            site_id:$('#site').val(),
            year:$('#year').val(),
            month_from:$('#month_from').val(),
            month_to:$('#month_to').val(),
            mode:mode
        }, function (response) {
            if (response.status)
                $.pnotify({
                    pnotify_title:'Успешно',
                    pnotify_text:response.count + ' новых запросов спарсили',
                    pnotify_hide:false
                });
            else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    }
}