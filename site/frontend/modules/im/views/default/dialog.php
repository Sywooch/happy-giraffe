<div id="dialog">
    <div class="opened-dialogs-list">
        <div class="t"></div>
        <div class="container">
            <ul>
                <?php $dialogs = ActiveDialogs::model()->getDialogs(); ?>
                <?php foreach ($dialogs as $dialog): ?>
                <li<?php if ($dialog['id'] == $id) echo ' class="active"' ?> id="dialog-<?php echo $dialog['id'] ?>">
                    <input type="hidden" value="<?php echo $dialog['id'] ?>" class="dialog-id">
                    <a href="#" class="remove"></a>

                    <div class="img"><img src="<?php echo $dialog['user']->pic_small->getUrl('mini') ?>"/></div>
                    <div class="status"><i class="icon"></i></div>
                    <div class="name"><span><?php echo $dialog['user']->getFullName() ?></span></div>
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






<script type="text/javascript">
    var window_active = 1;

    var dialog = <?php echo $id ?>;
    var last_massage = null;
    var no_more_messages = 0;

    $(function () {
        GoTop();
        $(window).focus(function () {
            window_active = 1;
            SetReadStatus();
        });
        $(window).blur(function () {
            window_active = 0;
        });

//        $('.new_comment iframe body').keypress(function (e) {
//            if (e.ctrlKey && e.keyCode == 13) {
//                SendMessage();
//            }
//        });

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
            var id = $(this).parents('div.dialog-message').attr("id").replace(/mess/g, "");
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
                            console.log(ul.find('li input.dialog-id'));
                            if (ul.find('li input.dialog-id').length == 0){
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
    });

    function ChangeDialog(id) {
        last_dialog = id;
        if (id == null) {
            window.location = "<?php echo $this->createUrl('/im/default/index', array()) ?>";
        } else {
            $('.opened-dialogs-list li').removeClass('active');
            $('#dialog-' + id + '').addClass('active');
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("im/default/ajaxDialog") ?>',
                data: {id:id},
                type: 'POST',
                dataType:'JSON',
                success: function(response) {
                    dialog = id;
                    last_massage = null;
                    no_more_messages = 0;
                    $('div.dialog-inn').html(response.html);
                    GoTop();
                    $('#messages').bind('scroll', MoreMessages);
                },
                context: $(this)
            });
        }
    }

    function SendMessage() {
        var editor = CKEDITOR.instances['MessageLog[text]'];
        var text = editor.getData();
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

    function MoreMessages(event) {
        if ($(this).scrollTop() < 20 && no_more_messages == 0) {
            var first_id = $('#messages .dialog-message:first').attr('id').replace(/mess/g, "");
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
                        for (var i = 0; i < 10; i++) {
                            h += $("#messages .dialog-message:eq(" + i + ")").outerHeight(true);
                        }

                        $("#messages").scrollTop(h);
                        $('#messages').delay(2000).bind('scroll', MoreMessages);
                    } else {
                        no_more_messages = 1;
                    }
                },
                context:$(this)
            });
        }
    }

    function SetReadStatus() {
        if (window_active && last_massage !== null)
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

    function ShowNewMessage(result) {
        last_massage = result.message_id;
        $("#messages").append(result.html);
        GoTop();
    }

    function ShowAsRead(result) {
        $(".dialog-message-new-out").each(function (index) {
            var id = $(this).attr("id").replace(/mess/g, "");
            if (id <= result.message_id) {
                $(this).removeClass("dialog-message-new-out");
            }
        });
    }

    function GoTop() {
        $("#messages").scrollTop($("#messages")[0].scrollHeight);
    }

</script>