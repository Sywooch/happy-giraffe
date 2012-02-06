<script type="text/javascript" src="/javascripts/dklab_realplexor.js"></script>
<style type="text/css">
    .unread {background: #9DD1FC;}
    input {border: 1px solid #000;}
    #messages {height: 300px;border: 1px solid #000;overflow: auto;}
    .mess_content {padding: 5px;margin: 3px;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;}
</style>
<div><a href="<?php echo $this->createUrl('/im/default/index') ?>">Все диалоги</a></div>

<?php $models = ActiveDialogs::model()->getDialogs(); ?>
<?php foreach ($models as $model): ?>
    <div><?php echo CHtml::link('user: '.$model->GetInterlocutor()->last_name,
        $this->createUrl('/im/default/dialog', array('id'=>$model->id))) ?></div>
<?php endforeach; ?>

<div id="messages">
    <?php foreach ($messages as $message): ?>
    <?php $this->renderPartial('_message', array(
        'message' => $message
    )); ?>
    <?php endforeach; ?>
</div>
<div class="new_comment">
    <?php
    $message = new MessageLog();
    $this->widget('ext.ckeditor.CKEditorWidget', array(
        'id'=>'message',
        'model' => $message,
        'attribute' => 'text',
        'config' => array(
            'toolbar' => 'Chat',
            'onkeyup'=>'testt'
        ),
    ));
    ?>
    <div class="button_panel">
        <button class="btn"><span><span>Добавить</span></span></button>
    </div>
</div>

<script type="text/javascript">
    var user_cache = '<?php echo MessageCache::GetCurrentUserCache() ?>';
    var window_active = 1;

    var dialog = <?php echo $id ?>;
    var last_massage = null;
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

        $('.new_comment iframe body').keypress(function (e) {
            if (e.ctrlKey && e.keyCode == 13){
                SendMessage();
            }
        });

        $('.button_panel .btn').click(function () {
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
        var editor = CKEDITOR.instances['MessageLog[text]'];
        var text = editor.getData();
        //console.log(text);
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
                    editor.on('keyup', testt);
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
            var first_id = $('#messages .mess_content:first').attr('id').replace(/mess/g, "");
            $('#messages').unbind('scroll');
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("im/default/moreMessages") ?>',
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

    function GoTop() {
        $("#messages").scrollTop($("#messages")[0].scrollHeight);
    }

</script>