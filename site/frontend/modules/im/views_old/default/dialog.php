<?php
Yii::app()->clientScript
    ->registerScriptFile('/javascripts/jquery.color.animation.js')
    ->registerScriptFile('/javascripts/scrollbarpaper.js');

?>
<div id="dialog">
    <div class="opened-dialogs-list">
        <ul>
            <?php $dialogs = ActiveDialogs::model()->getDialogs(); ?>
            <?php foreach ($dialogs as $dialog): ?>
                <?php $this->renderPartial('_dialog_preview',array(
                    'dialog'=>$dialog,
                    'current_dialog_id'=>$id
                )); ?>
            <?php endforeach; ?>
        </ul>
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
            <div class="editor-box">
                <?php
                $message = new Message();
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
</div>
<script type="text/javascript">
var window_active = 1;

var dialog = <?php echo $id ?>;
var last_massage = null;
var no_more_messages = 0;
var last_typing_time = 0;
var scrollBar = null;

var cke_instance = '<?php echo get_class($message); ?>[text]';

$(function () {
    if(history.replaceState)
        history.replaceState({ path:window.location.href }, '');

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

    //change dialog
    $('body').delegate('.opened-dialogs-list li', 'click', function () {
        var id = $(this).find('input.dialog-id').val();
        ChangeDialog(id);
    });

    //remove message
    $('body').delegate('div.dialog-message a.remove', 'click', function () {
        var id = $(this).parents('div.dialog-message').attr("id").replace(/Message_/g, "");
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

    //remove opened dialog
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

    //bind key press on CKEDITOR
    var editor = CKEDITOR.instances['Message[text]'];
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

    comet.addEvent(<?php echo CometModel::TYPE_MESSAGE_READ ?>, 'ShowAsRead');
    comet.addEvent(<?php echo CometModel::TYPE_USER_TYPING ?>, 'ShowUserTyping');
});

function ChangeDialog(id) {
    last_dialog = id;
    if (id == null) {
        window.location = "<?php echo $this->createUrl('/im/default/index', array()) ?>";
    } else {
        var new_dialog_unread_messages_count = parseInt($('#dialog-' + id + ' div.meta').html());
        $('.opened-dialogs-list li').removeClass('active');
        $('#dialog-' + id).addClass('active');
        $('#dialog-' + id + ' div.meta').hide();
        $('#dialog-' + id + ' div.meta').html('0');
        $('#dialog-' + id).removeClass('new-messages');

        if (typeof(window.history.pushState) == 'function'){
            var url = "<?php echo $this->createUrl('/im/default/dialog', array('id'=>'')) ?>"+id;
            window.history.pushState({ path: url },'',url);
        }

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

                //console.log($('#dialogs .header .count').html(), new_dialog_unread_messages_count);
                im.ShowNewMessagesCount(parseInt($('#dialogs .header .count').html()) - new_dialog_unread_messages_count);
            },
            context:$(this)
        });
    }
}

function SendMessage() {
    var editor = CKEDITOR.instances['Message[text]'];
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
                $('#messages .inner-messages').append(response.html);
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
        var first_id = $('#messages .dialog-message:first').attr('id').replace(/Message_/g, "");
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

                    SetScrollPosition(h);
                    $('#messages').bind('scroll', MoreMessages);
                } else {
                    no_more_messages = 1;
                    $('#messages').bind('scroll', MoreMessages);
                    if ($('#messages .inner-messages').height() > $("#messages").height())
                        $('#messages').scrollbarPaper('update');
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

function ShowNewMessage(result, id) {
    if (result.dialog_id == dialog) {
        //message recieved in current dialog
        last_massage = result.message_id;
        $("#messages .inner-messages").append(result.html);
        $("#messages .dialog-message-new-in:last td").css('background-color', '#EBF5FF');
        GoTop();
        SetReadStatus();
    } else {
        var li = $('#dialog-' + result.dialog_id);
        if (li.length > 0) {
            //message recieved in some opened dialog
            if (!li.hasClass('new-messages'))
                li.addClass('new-messages');
            var comment_count = li.find('.meta:first').text();
            var current_count = parseInt(comment_count) + 1;
            li.find('.meta:first').show().html(current_count);
            li.find('.meta:last').hide();
        }else{
            //message recieved in dialog that not represent there. Add it
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("/im/default/OpenedDialog") ?>',
                data: {id:result.dialog_id},
                type: 'POST',
                dataType:'JSON',
                success: function(response) {
                    if (response.status){
                        $('.opened-dialogs-list ul').append(response.html);
                    }
                },
                context: $(this)
            });
        }
        im.ShowNewMessagesCount(result.unread_count);
    }
}

Comet.prototype.ShowAsRead = function(result, id) {
    console.log('read!');
    $(".dialog-message-new-in").each(function (index) {
        var id = $(this).attr("id").replace(/Message_/g, "");
        if (id <= result.message_id) {
            $(this).find("td.content").css('background-color', '#EBF5FF');
            $(this).find("td.content").animate({ backgroundColor:"#fff" }, 2000);
            $(this).find("td.meta").css('background-color', '#EBF5FF');
            $(this).find("td.meta").animate({ backgroundColor:"#fff" }, 2000);
            $(this).find("td.actions").css('background-color', '#EBF5FF');
            $(this).find("td.actions").animate({ backgroundColor:"#fff" }, 2000);
            $(this).removeClass("dialog-message-new-in");

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

Comet.prototype.ShowUserTyping = function(result, id) {
    $('#dialog-' + result.dialog_id).append('<div class="meta"><i class="editing"></i></div>')
        .find('div.meta:last').delay(5000).fadeOut(300, function () {
            $(this).remove()
        });
}

function GoTop() {
    $("#messages").scrollTop($("#messages .inner-messages").outerHeight());
    if ($('#messages .inner-messages').height() > $("#messages").height())
        $('#messages').scrollbarPaper();
}

function SetScrollPosition(yPos) {
    $("#messages").scrollTop(yPos);
}
</script>