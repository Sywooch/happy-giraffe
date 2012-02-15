<?php
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/jquery.color.animation.js')
    ->registerScriptFile('/javascripts/jquery.jscrollpane.min.js')
    ->registerCssFile('/stylesheets/jquery.jscrollpane.css');
?>
<div id="dialog">
    <div class="opened-dialogs-list">
        <div class="t"></div>
        <div class="container">
            <ul>
                <?php $dialogs = ActiveDialogs::model()->getDialogs(); ?>
                <?php foreach ($dialogs as $dialog): ?>
                <?php $unread = MessageDialog::getUnreadMessagesCount($dialog['id']); ?>
                <li<?php
                    $class = '';
                    if ($unread > 0) $class = 'new-messages';
                    if ($dialog['id'] == $id) $class .= ' active';
                    $class = trim($class);
                    if (!empty($class))
                        echo ' class="' . $class . '"';
                    ?> id="dialog-<?php echo $dialog['id'] ?>">
                    <input type="hidden" value="<?php echo $dialog['id'] ?>" class="dialog-id">
                    <a href="#" class="remove"></a>

                    <div class="img"><img src="<?php echo $dialog['user']->getMiniAva() ?>"/></div>
                    <div class="status<?php if (!$dialog['user']->online) echo ' status-offline' ?>"><i
                        class="icon"></i></div>
                    <div class="name"><span><?php echo $dialog['user']->getFullName() ?></span></div>
                    <div
                        class="meta"<?php if ($unread == 0) echo ' style="display:none"'; ?>><?php echo $unread; ?></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="dialog-in">
        <div class="dialog-inn">
            <?php if ($id != null)
            $this->renderPartial('_dialog_content', array(
                'messages' => $messages,
                'id' => $id
            )); ?>
        </div>

        <div class="new-message">
            <?php
            $message = new MessageLog();
            $this->widget('ext.ckeditor.CKEditorWidget', array(
                'id' => 'message',
                'model' => $message,
                'attribute' => 'text',
                'config' => array(
                    'toolbar' => 'Chat',
                    'width' => 410,
                    'height' => 100,
                ),
            ));
            ?>
            <div class="buttons">
                <button class="btn btn-green-smedium"><span><span>Отправить</span></span></button>
            </div>
        </div>

    </div>
</div>
<style type="text/css">
    .cke_bottom {
        display: none;
    }
</style>
<script type="text/javascript">
var window_active = 1;

var dialog = <?php echo $id ?>;
var last_massage = null;
var no_more_messages = 0;
var last_typing_time = 0;
var pane = null;
var no_scroll = 0;

$(function () {
//    pane = $('.scroll').bind(
//        'jsp-arrow-change',
//        function(event, isAtTop, isAtBottom, isAtLeft, isAtRight)
//        {
//            console.log(event, isAtTop);
//            if (isAtTop && !no_scroll)
//                MoreMessages();
//        }
//    ).jScrollPane({
//        showArrows:true,
//        animateScroll:true,
//        arrowButtonSpeed:50,
//        autoReinitialise:true
//    });
    GoTop();

    $(window).focus(function () {
        window_active = 1;
        SetReadStatus();
    });
    $(window).blur(function () {
        window_active = 0;
    });

    $('.buttons .btn').click(function () {
        SendMessage();
        return false;
    });

    $('#messages').bind('scroll', MoreMessages);

    $('body').delegate('.opened-dialogs-list li', 'click', function () {
        var id = $(this).find('input.dialog-id').val();
        ChangeDialog(id);
    });

    $('body').delegate('div.dialog-message a.remove', 'click', function () {
        var id = $(this).parents('div.dialog-message').attr("id").replace(/MessageLog_/g, "");
        $(this).parents('div.dialog-message').remove();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("im/default/removeMessage") ?>',
            data:{id:id},
            type:'POST',
            dataType:'JSON',
            success:function (response) {

            },
            context:$(this)
        });

        return false;
    });

    $('body').delegate('.opened-dialogs-list a.remove', 'click', function () {
        var id = $(this).prev("input.dialog-id").val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("im/default/removeActiveDialog") ?>',
            data:{id:id},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    if ($(this).parent('li').hasClass('active')) {
                        var ul = $(this).parent('li').parent('ul');
                        $(this).parent('li').remove();
                        if (ul.find('li input.dialog-id').length == 0) {
                            ChangeDialog(null);
                        }
                        else {
                            ChangeDialog(ul.find('li input.dialog-id').val());
                        }
                    } else
                        $(this).parent('li').remove();
                }
            },
            context:$(this)
        });

        return false;
    });

    $('body').delegate('#dialog .dialog-inn a.remove-dialog', 'click', function () {
        if (confirm("Удалить диалог?")) {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/im/default/removeDialog") ?>',
                data:{id:dialog},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status) {
                        $('li#dialog-' + dialog).remove();
                        $('.dialog-inn').html('');

                        var ul = $('.opened-dialogs-list ul');
                        if (ul.find('li input.dialog-id').length == 0) {
                            ChangeDialog(null);
                        }
                        else {
                            ChangeDialog(ul.find('li input.dialog-id').val());
                        }

                        if (response.active_dialog_url == '')
                            $('.nav .opened').hide();
                        else
                            $('.nav .opened a').attr("href", response.active_dialog_url);
                    }
                },
                context:$(this)
            });
        }
        return false;
    });

    var editor = CKEDITOR.instances['MessageLog[text]'];
    editor.on('key', function (e) {
        if (last_typing_time + 10000 < new Date().getTime()) {
            last_typing_time = new Date().getTime();
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/im/default/UserTyping") ?>',
                data:{dialog_id:dialog},
                type:'POST'
            });
        }
        if (e.data.keyCode == 1114125) {
            SendMessage();
        }
        SetReadStatusForIframe();
    });
    editor.on('mouseup', function () {
        SetReadStatusForIframe();
    });

    $("body").delegate(".dialog-message a.claim", "click", function (e) {
        e.preventDefault();
        report($(this).parents(".dialog-message"));
    });
});

function ChangeDialog(id) {
    last_dialog = id;
    if (id == null) {
        window.location = "<?php echo $this->createUrl('/im/default/index', array()) ?>";
    } else {
        $('.opened-dialogs-list li').removeClass('active');
        $('#dialog-' + id).addClass('active');
        $('#dialog-' + id + ' div.meta').hide();
        $('#dialog-' + id + ' div.meta').html('0');
        $('#dialog-' + id).removeClass('new-messages');
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("im/default/ajaxDialog") ?>',
            data:{id:id},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                dialog = id;
                last_massage = null;
                no_more_messages = 0;
                last_typing_time = 0;
                $('div.dialog-inn').html(response.html);
                GoTop();
                $('#messages').bind('scroll', MoreMessages);
            },
            context:$(this)
        });
    }
}

function SendMessage() {
    var editor = CKEDITOR.instances['MessageLog[text]'];
    var text = editor.getData();
    if (text == '')
        return false;
    editor.setData('');
    $.ajax({
        url:'<?php echo Yii::app()->createUrl("im/default/CreateMessage") ?>',
        data:{dialog:dialog, text:text},
        type:'POST',
        dataType:'JSON',
        success:function (response) {
            if (response.status) {
                $('#messages').append(response.html);
                GoTop();
                editor.focus();
            } else {
                editor.setData(text);
            }
        },
        error:function (jqXHR, textStatus, errorThrown) {
            editor.setData(text);
        },
        context:$(this)
    });
}

function MoreMessages() {
    if (no_more_messages == 0 && $('#messages').scrollTop() < 10) {
//        no_scroll = 1;
        var first_id = $('#messages .dialog-message:first').attr('id').replace(/MessageLog_/g, "");
        $('#messages').unbind('scroll');
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("im/default/moreMessages") ?>',
            data:{id:first_id, dialog_id:dialog},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $('#messages .dialog-message:first').before(response.html);

                    var h = 0;
                    for (var i = 1; i < response.count; i++)
                        h += $("#messages .dialog-message:eq(" + i + ")").outerHeight(true);

                    $("#messages").scrollTop(h);
                    $('#messages').bind('scroll', MoreMessages);
//                    SetScrollPosition(h);
//                    no_scroll = 0;
                } else {
                    no_more_messages = 1;
                }
            },
            context:$(this)
        });
    }
}

function SetReadStatus() {
    if (window_active && last_massage !== null) {
        $("#messages .dialog-message-new-in td").animate({ backgroundColor:"#fff" }, 2000);
        $('.dialog-message-new-in').removeClass('dialog-message-new-in');

        $.ajax({
            url:'<?php echo Yii::app()->createUrl("im/default/SetRead") ?>',
            data:{dialog:dialog, id:last_massage},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                last_massage = null;
            },
            context:$(this)
        });
    }
}

function SetReadStatusForIframe() {
    if (last_massage !== null) {
        $("#messages .dialog-message-new-in td").animate({ backgroundColor:"#fff" }, 2000);
        $('.dialog-message-new-in').removeClass('dialog-message-new-in');

        $.ajax({
            url:'<?php echo Yii::app()->createUrl("im/default/SetRead") ?>',
            data:{dialog:dialog, id:last_massage},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                last_massage = null;
            },
            context:$(this)
        });
    }
}

function ShowNewMessage(result) {
    if (result.dialog_id == dialog) {
        last_massage = result.message_id;
        $("#messages").append(result.html);
        $("#messages .dialog-message-new-in:last td").css('background-color', '#EBF5FF');
        GoTop();
        SetReadStatus();
    } else {
        var li = $('#dialog-' + result.dialog_id);
        if (!li.hasClass('new-messages'))
            li.addClass('new-messages');
        var comment_count = li.find('.meta:first').text();
        var current_count = parseInt(comment_count) + 1;
        li.find('.meta:first').show().html(current_count);
        li.find('.meta:last').hide();
    }
}

function ShowAsRead(result) {
    $(".dialog-message-new-out").each(function (index) {
        var id = $(this).attr("id").replace(/MessageLog_/g, "");
        if (id <= result.message_id) {
            $(this).find("td.content").css('background-color', '#EBF5FF');
            $(this).find("td.content").animate({ backgroundColor:"#fff" }, 2000);
            $(this).find("td.meta").css('background-color', '#EBF5FF');
            $(this).find("td.meta").animate({ backgroundColor:"#fff" }, 2000);
            $(this).find("td.actions").css('background-color', '#EBF5FF');
            $(this).find("td.actions").animate({ backgroundColor:"#fff" }, 2000);
            $(this).removeClass("dialog-message-new-out");

        }
    });
}

function StatusChanged(result) {
    if (dialog == result.dialog_id) {
        if (result.online == 1) {
            $('.user-details span.status-offline').removeClass('status-offline').addClass('status-online');
        } else {
            $('.user-details span.status-online').removeClass('status-online').addClass('status-offline');
        }
    }

    if (result.online == 1) {
        $('#dialog-' + result.dialog_id + ' div.status').removeClass('status-offline');
    } else {
        if (!$('.opened-dialogs-list ul li.active div.status').hasClass('status-offline'))
            $('.opened-dialogs-list ul li.active div.status').addClass('status-offline');
    }
}

function ShowUserTyping(result) {
    $('#dialog-' + result.dialog_id).append('<div class="meta"><i class="editing"></i></div>')
        .find('div.meta:last').delay(5000).fadeOut(300, function () {
            $(this).remove()
        });
}

function GoTop() {
    SetScrollPosition($("#messages")[0].scrollHeight);
    //$("#messages").scrollTop($("#messages")[0].scrollHeight);
}

function report(item) {
    if (item.next().attr('class') != 'report-block') {
        var source_data = item.attr('id').split('_');
        $.ajax({
            type:'POST',
            data:{
                source_data:{
                    model:source_data[0],
                    object_id:source_data[1]
                }
            },
            url:"<?php echo  $this->createUrl('/ajax/showreport') ?>",
            success:function (response) {
                item.after(response);
            }
        });
    }
    else {
        item.next().remove();
    }
}

function SetScrollPosition(yPos){
    //pane.data('jsp').scrollTo(0, yPos);
    $("#messages").scrollTop(yPos)
}
function getScrollContentPosition(){
    return pane.data('jsp').getContentPositionY();
}
</script>