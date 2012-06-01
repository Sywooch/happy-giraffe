/**
 * Author: alexk984
 * Date: 02.04.12
 * Time: 15:57
 */
var SeoModule = {
    GetArticleInfo:function () {
        var url = $('input.article-url').val();
        $.post('/task/getArticleInfo/', {url:url}, function (response) {
            $('.info').html(response.title + '<br>' + response.keywords);
            SeoModule.id = response.id;
        }, 'json');
    },
    SaveArticleKeys:function () {
        $.post('/existArticles/SaveArticleKeys/', {
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
    parseQueries:function () {
        $.post('/queries/parse/', function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title: 'Успешно',
                    pnotify_text: 'Спарсили ' + response.count + ' запросов'
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
                    pnotify_title: 'Успешно',
                    pnotify_text: response.count + ' потоков запущено'
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
                    pnotify_title: 'Успешно',
                    pnotify_text: 'Новые прокси внесены в базу'
                });
            }
        }, 'json');
    },
    stopThreads:function () {
        $.post('/queries/stopThreads/', function (response) {
            if (response.status) {
                $.pnotify({
                    pnotify_title: 'Успешно',
                    pnotify_text: 'Сигнал передан, в течении минуты потоки должны завершиться'
                });
            }
        }, 'json');
    }
}