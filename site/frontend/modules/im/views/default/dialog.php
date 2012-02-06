<script type="text/javascript" src="/javascripts/dklab_realplexor.js"></script>
<style type="text/css">
    .unread {background: #9DD1FC;}
    input {border: 1px solid #000;}
    #messages {height: 300px;border: 1px solid #000;overflow: auto;}
    .mess_content {padding: 5px;margin: 3px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
</style>
<div id="messages">
    <?php foreach ($messages as $message): ?>
    <?php $this->renderPartial('_message', array(
        'message' => $message
    )); ?>
    <?php endforeach; ?>
</div>
<input type="text" id="mess-text"><br>
<?php echo CHtml::link('send_message', '#', array('id' => 'send_message')) ?>

<script type="text/javascript">
    var user_cache = '<?php echo MessageCache::GetCurrentUserCache() ?>';
    var dialog = <?php echo $id ?>;
    var last_massage = null;
    var window_active = 1;
    var no_more_messages = 0;

    $(function () {
        GoTop();

        $(window).focus(function(){
            window_active = 1;
            SetReadStatus();
        });
        $(window).blur(function(){
            window_active = 0;
        });

        $('#mess-text').keypress(function (e) {
            if (e.which == 13) {
                SendMessage();
            }
        });

        $('a#send_message').click(function () {
            SendMessage();
            return false;
        });

        var realplexor = new Dklab_Realplexor(
            "http://<?php echo Yii::app()->comet->host ?>",
            "<?php echo Yii::app()->comet->namespace ?>"
        );

        realplexor.subscribe(user_cache, function (result, id) {
            console.log(result);
            if (result.type == <?php echo MessageLog::TYPE_NEW_MESSAGE ?>) {
                last_massage = result.message_id;
                $('#messages').append(result.html);
                GoTop();
            } else if (result.type == <?php echo MessageLog::TYPE_READ ?>) {
                //SHOW AS READ
                $('.mess_content.unread').each(function (index) {
                    var id = $(this).attr('id').replace(/mess/g, "");
                    if (id <= result.message_id) {
                        $(this).removeClass('unread');
                    }
                });
            }
        });

        $('#messages').bind('scroll', MoreMessages);
        realplexor.execute();
    });

    function SendMessage() {
        var text = $('#mess-text').val();
        $('#mess-text').val('');
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("im/CreateMessage") ?>',
            data:{dialog:dialog, text:text},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $('#messages').append(response.html);
                    GoTop();
                } else {
                    $('#mess-text').val(text);
                }
            },
            error:function (jqXHR, textStatus, errorThrown) {
                $('#mess-text').val(text);
            },
            context:$(this)
        });
    }

    function MoreMessages(event) {
        if ($(this).scrollTop() < 20 && no_more_messages == 0) {
            var first_id = $('#messages .mess_content:first').attr('id').replace(/mess/g, "");
            $('#messages').unbind('scroll');
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("im/moreMessages") ?>',
                data:{id:first_id, dialog_id:dialog},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status) {
                        $('#messages .mess_content:first').before(response.html);

                        var h = 0;
                        for (var i = 0; i < 10; i++) {
                            h += $("#messages .mess_content:eq(" + i + ")").outerHeight(true);
                        }
                        $("#messages").scrollTop(h);
                        $('#messages').bind('scroll', MoreMessages);
                    }else{
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
            url:'<?php echo Yii::app()->createUrl("im/SetRead") ?>',
            data:{dialog:dialog, id:last_massage},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                last_massage = null;
            },
            context:$(this)
        });
    }

    function GoTop() {
        $("#messages").scrollTop($("#messages")[0].scrollHeight);
    }

</script>