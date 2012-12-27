var Messages = {
    editor:null,
    activeTab:null,
    hasMessages:true,
    active:false,
    contactsPage:1,
    loadContacts:false
}

Messages.open = function (interlocutor_id, type) {
    type = (typeof type === "undefined") ? 0 : type;
    interlocutor_id = (typeof interlocutor_id === "undefined") ? null : interlocutor_id;

    Popup.load('Messages');

    if (!Messages.isActive()) {
        $.get('/im/', function (data) {
            $('#popup-preloader').hide();
            $('.popup-container').append(data.html);
            $('.user-nav-2 .item-dialogs').addClass('active');

            comet.addEvent(3, 'updateStatus');
            comet.addEvent(21, 'updateReadStatuses');
            $(window).on('resize', function () {
                Messages.setHeight();
            });

            Messages.editor = CKEDITOR.instances['Message[text]'];

            //Messages.updateCounter('#user-dialogs-allCount', data.allCount, false);
            //Messages.updateCounter('#user-dialogs-newCount', data.newCount, false);
            //Messages.updateCounter('#user-dialogs-onlineCount', data.onlineCount, false);
            //Messages.updateCounter('#user-dialogs-friendsCount', data.friendsCount, false);
            Messages.hasMessages = data.hasMessages;
            console.log(data.hasMessages);
            Messages.initialize(interlocutor_id, type);
        }, 'json');
    }
    else {
        Messages.initialize(interlocutor_id, type);
    }
}

Messages.initialize = function (interlocutor_id, type) {
    if (!Messages.hasMessages && !Messages.isActive() && interlocutor_id == null) {
        Messages.setList(type, false);
        Messages.showEmpty();
    } else {
        if (Messages.activeTab != type) {
            Messages.setList(type, interlocutor_id);
        } else {
            Messages.setDialog(interlocutor_id);
        }
    }
    Messages.active = true;

    /*if (Messages.activeTab != type) {
     if (! Messages.hasMessages && interlocutor_id == null) {
     Messages.setList(type, false);
     Messages.showEmpty();
     } else {
     Messages.setList(type, interlocutor_id);
     }
     } else {
     if (interlocutor_id != null)
     Messages.setDialog(interlocutor_id);
     }*/
}

Messages.close = function () {
    $('#user-dialogs').remove();
    Popup.unload();
    $('.user-nav-2 .item-dialogs').removeClass('active');
    if (Messages.editor)
        Messages.editor.destroy(true);
    comet.delEvent(3, 'updateStatus');
    comet.delEvent(21, 'updateReadStatuses');
    $(window).off('resize', function () {
        Messages.setHeight();
    });

    Messages.activeTab = null;
    Messages.active = false;
}

/*
 Messages.open = function(interlocutor_id) {
 interlocutor_id = (typeof interlocutor_id === "undefined") ? null : interlocutor_id;

 if (! Messages.isActive()) {
 $.get('/im/', function(data) {
 $('body').append(data.html);
 $('body').css('overflow', 'hidden');
 $('body').append('<div id="body-overlay"></div>');
 $('body').addClass('nav-fixed');
 Messages.setList(0, interlocutor_id == null && ! data.hasMessages, interlocutor_id);
 comet.addEvent(3, 'updateStatus');
 comet.addEvent(1, 'receiveMessage');
 comet.addEvent(21, 'updateReadStatuses');
 $(window).on('resize', function() {
 Messages.setHeight();
 });
 }, 'json');
 } else {
 Messages.setDialog(interlocutor_id);
 }
 }

 Messages.close = function() {
 $('#user-dialogs').remove();
 $('body').css('overflow', '');
 $('#body-overlay').remove();
 $('body').removeClass('nav-fixed');
 if (CKEDITOR.instances['Message[text]']) {
 CKEDITOR.instances['Message[text]'].destroy(true);
 }
 comet.delEvent(3, 'updateStatus');
 comet.delEvent(1, 'receiveMessage');
 comet.delEvent(21, 'updateReadStatuses');
 $(window).off('resize', function() {
 Messages.setHeight();
 });
 }
 */

Messages.toggle = function () {
    Messages.isActive() ? Messages.close() : Messages.open();
}

Messages.isActive = function () {
    return Messages.active;
}

Messages.setHeight = function () {
    var box = $('#user-dialogs');

    var windowH = $(window).height();
    var headerH = 90;
    var textareaH = box.find('.dialog-input').hasClass('wysiwyg-input') ? 150 : 100;
    var userH = 110;
    var marginH = 30;

    var wannaChatH = box.find('.contacts .wannachat').size() > 0 ? 150 : 0;

    var generalH = windowH - marginH * 2 - headerH;
    if (generalH < 400) generalH = 400;

    box.find('.contacts').height(generalH);
    box.find('.dialog').height(generalH);

    box.find('.contacts .list').height(generalH - wannaChatH);
    box.find('.dialog .dialog-messages').height(generalH - textareaH - userH);
}

Messages.setList = function (type, interlocutor_id) {
    interlocutor_id = (typeof interlocutor_id === "undefined") ? null : interlocutor_id;
    Messages.activeTab = type;


    $.get('/im/contacts/', {type:type}, function (data) {
        $('#user-dialogs .contacts div.list').scrollTop(0);
        $('#user-dialogs-contacts').html(data);
        $('#user-dialogs-contacts li').each(function () {
            Messages.updateNew(this);
        });

        //switch nav
        $('#user-dialogs-nav li.active span.count').show();
        $('#user-dialogs-nav li.active').removeClass('active');
        $('#user-dialogs-nav li:eq(' + type + ') span.count').text($('#user-dialogs-contacts li').length);
        $('#user-dialogs-nav li:eq(' + type + ')').addClass('active');
        $('#user-dialogs-nav li.active span.count').hide();

        if (interlocutor_id != false) {
            var dialog = (interlocutor_id == null) ? $('#user-dialogs-contacts > li:first').data('userid') : interlocutor_id;
            Messages.setDialog(dialog);
        }

        var scroll_container = $('#user-dialogs .contacts div.list');

        scroll_container.scroll(function () {
            console.log(scroll_container.scrollTop(), $('#user-dialogs-contacts').height());

            if (((scroll_container.scrollTop()) + 500) >= $('#user-dialogs-contacts').height()) {
                Messages.loadMoreContacts();
            }
        });
    });
}

Messages.loadMoreContacts = function () {
    if (!Messages.loadContacts) {
        Messages.loadContacts = true;
        $.get('/im/contacts/', {type:Messages.activeTab, page:Messages.contactsPage + 1}, function (data) {
            $('#user-dialogs-contacts').append(data);
            $('#user-dialogs-contacts li').each(function (index, element) {
                if (index > Messages.contactsPage * 20)
                    Messages.updateNew(this);
            });
            Messages.contactsPage++;
            Messages.loadContacts = false;
        });
    }
}


Messages.showEmpty = function () {
    $.get('/im/empty/', function (data) {
        $('#user-dialogs-dialog').html(data);
        $('.dialog-input').hide();
        Messages.setHeight();
    });
}

Messages.setDialog = function (interlocutor_id) {
    $.get('/im/dialog/', {interlocutor_id:interlocutor_id}, function (data) {
        //update new counter
        Messages.updateCounter('#user-dialogs-newCount', data.newCount, false);
        Messages.updateMenuCounter(data.menuCount, false);

        //add contact if its absent
        if ($('#user-dialogs-contacts li[data-userid="' + interlocutor_id + '"]').length == 0)
            $('#user-dialogs-contacts').prepend(data.contactHtml);

        //show dialog
        $('#user-dialogs-dialog').html(data.html);
        $('#user-dialogs-dialog').data('dialogid', data.dialogid);
        $('#user-dialogs-dialog').data('interlocutorid', interlocutor_id);

        //set read statuses
        Messages.setReadStatus();

        //switch active dialog
        $('#user-dialogs-contacts li.active').removeClass('active');
        $('#user-dialogs-contacts li[data-userid="' + interlocutor_id + '"]').addClass('active');
        $('#user-dialogs-contacts li[data-userid="' + interlocutor_id + '"]').data('unread', 0);

        //update counter
        Messages.updateNew($('#user-dialogs-contacts li[data-userid="' + interlocutor_id + '"]'));

        if ($('.dialog-input').is(':hidden'))
            $('.dialog-input').show();
        if (interlocutor_id == 1) {
            $('.dialog-input').hide();
        }

        Messages.setHeight();
        Messages.scrollDown();

        if (Messages.editor)
            Messages.editor.focus();
    }, 'json');
}

Messages.markAsRead = function () {
    $.post('/im/markAsRead/', {
        dialog_id:$('#user-dialogs-dialog').data('dialogid'),
        interlocutor_id:$('#user-dialogs-dialog').data('interlocutorid')
    });
}

Messages.sendMessage = function () {
    var form = $('#user-dialogs-form');

    $.post(form.attr('action'), {
        interlocutor_id:$('#user-dialogs-dialog').data('interlocutorid'),
        text:Messages.editor.getData()
    }, function (data) {
        if (data.status == 1) {
            Messages.editor.setData('');
            $('#user-dialogs-dialog .dialog-messages ul li.empty').hide();

            $('.dialog-messages > ul').append(data.html);
            var message = $('.dialog-messages > ul > li:data(id=' + data.message_id + ')');
            if ($('.dialog-messages > .empty:visible').length > 0)
                $('.dialog-messages > .empty').hide();
            Messages.scrollDown();

            //move top
            if ($('#user-dialogs-contacts li[data-userid="' + $('#user-dialogs-dialog').data('interlocutorid') + '"]').index() != 0)
                $('#user-dialogs-contacts li:first').before($('#user-dialogs-contacts li[data-userid="' + $('#user-dialogs-dialog').data('interlocutorid') + '"]'));

            //update counter
            if (data.newDialog)
                Messages.updateCounter('#user-dialogs-allCount', 1);

            //set read status as unread if message is not read in 2 sec
            setTimeout(function () {
                if (message.data('read') == 0) {
                    message.find('span.read_status').html('<span class="message-label label-unread">Сообщение не прочитано</span>');
                }
            }, 2000);

            Messages.editor.focus();
        }
    }, 'json');
}

Messages.updateCounter = function (selector, value, diff) {
    diff = (typeof diff === "undefined") ? true : diff;

    var newValue = (diff) ? parseInt($(selector).text()) + value : value;
    $(selector).text(newValue);
    if (newValue == 0) {
        $(selector).parents('li').addClass('disabled');
    } else {
        if ($(selector).parents('li').hasClass('disabled'))
            $(selector).parents('li').removeClass('disabled');
    }
}


Messages.updateMenuCounter = function (value, diff) {
    diff = (typeof diff === "undefined") ? true : diff;

    var li = $('.user-nav-2 .item-dialogs');
    var counter = li.find('.count span.count-red');
    var newVal = (diff) ? parseInt(counter.text()) + value : value;

    counter.text(newVal);
    li.toggleClass('new', newVal != 0);
}

Messages.filterList = function (filter) {
    if (filter) {
        $('#user-dialogs-contacts > li').filter(function (index) {
            var un = $(this).find('span.username').text().toUpperCase();
            var term = filter.toUpperCase();
            return un.indexOf(' ' + term) != -1 || un.indexOf(term) == 0;
        }).slideDown();
        $('#user-dialogs-contacts > li').filter(function (index) {
            var un = $(this).find('span.username').text().toUpperCase();
            var term = filter.toUpperCase();
            return !(un.indexOf(' ' + term) != -1 || un.indexOf(term) == 0);
        }).slideUp();
    } else {
        $('#user-dialogs-contacts > li').slideDown();
    }
}

Messages.scrollDown = function () {
    $(".dialog-messages").prop('scrollTop', $(".dialog-messages").prop("scrollHeight"));
}

Messages.showInput = function () {
    Messages.editor = CKEDITOR.instances['Message[text]'];

    $('.dialog-input').addClass('wysiwyg-input');

    setMessagesHeight();
    Messages.scrollDown();

    Messages.editor.on('key', function (e) {
        if (e.data.keyCode == 1114125) {
            Messages.sendMessage();
        }
    });

    Messages.editor.focus();
}

Messages.updateNew = function (el) {
    var number = $(el).data('unread');
    var noun = declOfNum(number, ['новое', 'новых', 'новых']);
    $(el).find('span.unread').html($('#newTmpl').tmpl({number:number, noun:noun}));
}

Messages.setReadStatus = function () {
    var interlocutor_id = $('#user-dialogs-dialog').data('interlocutorid');
    $('.dialog-messages span.read_status').html('');
    $('.dialog-messages > ul > li[data-authorid!="' + interlocutor_id + '"]:data(read=0) span.read_status').html('<span class="message-label label-unread">Сообщение не прочитано</span>');
    $('.dialog-messages > ul > li[data-authorid!="' + interlocutor_id + '"]:data(read=1):last span.read_status').html('<span class="message-label label-read">Сообщение прочитано</span>');
}


Comet.prototype.updateReadStatuses = function (result, id) {
    var dialog_id = $('#user-dialogs-dialog').data('dialogid');
    var interlocutor_id = $('#user-dialogs-dialog').data('interlocutorid');
    if (result.dialog_id == $('#user-dialogs-dialog').data('dialogid')) {
        $('.dialog-messages > ul > li[data-authorid!="' + interlocutor_id + '"]').data('read', '1');
        Messages.setReadStatus();
    }
}

Comet.prototype.updateStatus = function (result, id) {
    var indicators = $('[data-userid=' + result.user_id + '] .icon-status');
    if (result.online == 1) {
        indicators.removeClass('status-offline').addClass('status-online');
        Messages.updateCounter('#user-dialogs-onlineCount', 1);
        if (result.is_friend)
            Messages.updateCounter('#user-dialogs-friendsCount', 1);
    } else {
        indicators.removeClass('status-online').addClass('status-offline');
        Messages.updateCounter('#user-dialogs-onlineCount', -1);
        if (result.is_friend)
            Messages.updateCounter('#user-dialogs-friendsCount', -1);
    }
}

Comet.prototype.receiveMessage = function (result, id) {
    Messages.updateMenuCounter(1);

    if (Messages.isActive()) {
        //add message
        if (result.from == $('#user-dialogs-dialog').data('interlocutorid')) {
            $('.dialog-messages > ul').append(result.html);
            Messages.markAsRead();
            Messages.scrollDown();
        }

        Messages.updateCounter('#user-dialogs-newCount', result.newCount, false);
        if (result.newDialog)
            Messages.updateCounter('#user-dialogs-allCount', 1);

        //update contact-list
        if ($('#user-dialogs-contacts li[data-userid="' + result.from + '"]').length != 0) {
            //move contact on top
            if ($('#user-dialogs-contacts li[data-userid="' + result.from + '"]').index() != 0)
                $('#user-dialogs-contacts li:first').before($('#user-dialogs-contacts li[data-userid="' + result.from + '"]'));

            //update unread counter
            if ($('#user-dialogs-dialog').data('interlocutorid') != result.from) {
                $('#user-dialogs-contacts li[data-userid="' + result.from + '"]').data('unread', $('#user-dialogs-contacts li[data-userid="' + result.from + '"]').data('unread') + 1);
                Messages.updateNew($('#user-dialogs-contacts li[data-userid="' + result.from + '"]'));
            }
        } else {
            //add contact
            if (Messages.activeTab == 0 || Messages.activeTab == 1) {
                $('#user-dialogs-contacts').prepend(result.contactHtml);
            }
        }
    }
}

$(function () {
    comet.addEvent(1, 'receiveMessage');
});
