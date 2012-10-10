var Popup = {
    list : ['Messages', 'Friends', 'Notifications', 'Settings'],
    current : null
}

Popup.load = function(name) {
    if (this.current !== null && this.current != name)
        window[this.current]['close']();

    this.current = name;

    //$('body').css('overflow', 'hidden');
    //$('body').addClass('nav-fixed');
    $('#body-overlay').show();
    $('.popup-container').show();
    $('#popup-preloader').show();
}

Popup.unload = function() {
    //$('body').css('overflow', '');
    //$('body').removeClass('nav-fixed');
    $('#body-overlay').hide();
    $('.popup-container').hide();
}

$(function() {
    $('#user-nav-friends').delegate('i.close', 'click', function(e) {
        e.preventDefault();
        var el = $(this).closest('li');
        var id = el.attr('id');
        $.ajax({
            type: 'post',
            url: '/notification/delete/',
            data: {
                id: id
            },
            success: function(response) {
                if (response) {
                    el.remove();

                }
            }
        })
    });

    $('body').delegate('div.user-weather #forecast-link', 'click', function(){
        $('#today-weather').fadeOut(250, function(){
            $('#forecast').fadeIn(250);
        });
        return false;
    });

    $('body').delegate('div.user-weather #today-link', 'click', function(){
        $('#forecast').fadeOut(250, function(){
            $('#today-weather').fadeIn(250);
        });
        return false;
    });

    $('#change_ava').delegate('a.renew', 'click', function() {
        $('#change_ava > div.photo > a').trigger('click');
    });
});

function updateIm(count, data)
{
    $('#user-nav-messages span.count').text(count).toggle(count != 0);
    $('#user-nav-messages ul.list').html($('#imNotificationTmpl').tmpl(data));
}

function sendInvite(el, user_id) {
    $.ajax({
        dataType: 'json',
        type: 'post',
        url: '/friendRequests/send/',
        data: {
            to_id: user_id
        },
        success: function (response) {
            if (response.status) {
                $(el).replaceWith(response.html);
            }
        }
    });

}

function deleteFriend(el, user_id, friendPage) {
    $.ajax({
        dataType: 'json',
        type: 'post',
        url: '/friendRequests/delete/',
        data: {
            friend_id: user_id
        },
        success: function (response) {
            if (response.status) {
                (friendPage) ? $.fn.yiiListView.update('friends') : $(el).replaceWith(response.html);
            }
        }
    });
}

function setMessagesHeight(){

    var box = $('#user-dialogs');

    var windowH = $(window).height();
    var headerH = 90;
    var textareaH = box.find('.dialog-input').hasClass('wysiwyg-input') ? 150 : 100;
    var userH = 110;
    var marginH = 30;

    var wannaChatH = box.find('.wannachat').size() > 0 ? 150 : 0;

    var generalH = windowH - marginH*2 - headerH;
    if (generalH < 400) generalH = 400;

    box.find('.contacts').height(generalH);
    box.find('.dialog').height(generalH);

    box.find('.contacts .list').height(generalH - wannaChatH);
    box.find('.dialog .dialog-messages').height(generalH - textareaH - userH);

}
