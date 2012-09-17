/**
 * Author: alexk984
 * Date: 12.09.12
 */

var ExtLinks = {
    problem_type:0,
    site_id:null,
    CheckSite:function () {
        var url = $('#site_url').val();
        $.post('/externalLinks/sites/checkSite/', {url:url}, function (response) {
            $('.url-actions').hide();
            switch (response.type) {
                case 1:
                    $('#site_status_1').show();
                    break;
                case 2:
                    $('#site_status_2').show();
                    $('.url-list').html(response.links).show();
                    break;
                case 3:
                    $('#site_status_3').show();
                    break;
            }
        }, 'json');
    },
    CancelSite:function () {
        ExtLinks.ClearFrom();
    },
    AddSite:function () {
        $.post('/externalLinks/sites/addSite/', {url:$('#site_url').val()}, function (response) {
            if (response.status) {
                $('#ELLink_site_id').val(response.id);
                $('div.form').show();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Ошибка, обратитесь к разработчикам'
                });
        }, 'json');
    },
    AddForum:function () {
        var url = $('#site_url').val();
        $.post('/externalLinks/forums/add/', {url:url, create_task:1}, function (response) {
            if (response.status) {
                $('.flash-message.added').html('Форум &nbsp;<a target="_blank" href="' + url +
                    '">' + url + '</a> добавлен в задачи').show().delay(3000).fadeOut(3000);
                ExtLinks.ClearForum();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Ошибка, обратитесь к разработчикам'
                });
        }, 'json');
    },
    AddForumExecuted:function () {
        var url = $('#site_url').val();
        $.post('/externalLinks/forums/add/', {url:url}, function (response) {
            if (response.status) {
                $('div.form').show();
                ExtLinks.site_id = response.id;
                $('#ELLink_site_id').val(response.id);
                $('div.reg-form').replaceWith(response.account);
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Ошибка, обратитесь к разработчикам'
                });
        }, 'json');
    },
    AddToBL:function (site) {
        var url = $('#site_url').val();
        $.post('/externalLinks/sites/addToBlacklist/', {url:url}, function (response) {
            if (response.status) {
                var flash = $('.flash-message.added');
                if (site == 1) {
                    flash.html('Сайт &nbsp;<a target="_blank" href="' + url +
                        '">' + url + '</a> помещен в черный список').show().delay(3000).fadeOut(3000);
                    ExtLinks.ClearFrom();
                }
                else {
                    flash.html('Форум &nbsp;<a target="_blank" href="' + url +
                        '">' + url + '</a> помещен в черный список').show().delay(3000).fadeOut(3000);
                    ExtLinks.ClearForum();
                }
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    CheckLinkType:function (el, type) {
        $('#ELLink_link_type').val(type);
        $('.link-types .icon-links').removeClass('active');
        $(el).addClass('active')
    },
    ClearFrom:function () {
        $('div.form').hide();
        $('.url-actions').hide();
        $('#site_url').val('');

        $('#ELLink_url').val('');
        $('#ELLink_site_id').val('');
        $('#ELLink_our_link').val('');
        $('.anchors input').val('');
        $('.anchors input:last').hide();
        $('.url-list').hide().html('');

        $('input [name="paid_link"]').attr('checked', false);
        $('#ELLink_link_cost').val('');
    },
    ClearForum:function () {
        $('#site_url').val('');
        $('.url-actions').hide();
    },
    Checked:function (el, id, success) {
        $.post('/externalLinks/check/checked/', {id:id, success:success}, function (response) {
            if (response.status) {
                $(el).parents('tr').remove();
                $('div.count a').text(parseInt($('div.count a').text()) - 1);
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:'Ошибка, обратитесь к разработчикам'
                });

        }, 'json');
    },
    AfterSiteAdd:function () {
        ExtLinks.ClearFrom();
        var flash = $('.flash-message.added');
        flash.html('Ваша ссылка добавлена &nbsp;<a href="/externalLinks/sites/reports/">Перейти</a>').show().delay(3000).fadeOut(3000);
    },
    TakeForum:function (el, id) {
        $.post('/externalLinks/tasks/takeForum/', {id:id}, function (response) {
            console.log(response);
            if (response.status) {
                window.location.reload();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    AddForumLogin:function (el, site_id) {
        var login = $('#forum-login').val();
        var password = $('#forum-password').val();

        $.post('/externalLinks/tasks/addForumLogin/', {
            login:login,
            password:password,
            site_id:ExtLinks.site_id
        }, function (response) {
            if (response.status) {
                $(el).hide();
                $(el).next().show();
                $(el).parents('.reg-form').find('input[type="text"]').prop('disabled', true);
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    EditLogin:function(el){
        $(el).hide();
        $(el).prev().show();
        $(el).parents('.reg-form').find('input[type="text"]').prop('disabled', false);
    },
    Problem:function (id) {
        $.post('/externalLinks/tasks/problem/', {
            type:ExtLinks.problem_type,
            id:id
        }, function (response) {
            if (response.status) {
                window.location.reload();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    },
    checkProblem:function (el, type) {
        ExtLinks.problem_type = type;
        $('.problem-in .radio').removeClass('active');
        if (!$(el).hasClass('active'))
            $(el).addClass('active');
    },
    Executed:function (id) {
        $.post('/externalLinks/tasks/executed/', {
            id:id
        }, function (response) {
            if (response.status) {
                window.location.reload();
            } else
                $.pnotify({
                    pnotify_title:'Ошибка',
                    pnotify_type:'error',
                    pnotify_text:response.error
                });
        }, 'json');
    }
}