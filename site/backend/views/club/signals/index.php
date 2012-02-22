<?php
/* @var $this Controller
 * @var $models UserSignal[]
 */

Yii::app()->clientScript
    ->registerScriptFile('/js/dklab_realplexor.js')
    ->registerCssFile('/css/jquery.ui/theme.css');
?>
<?php $this->renderPartial('_style',array()); ?>
<script type="text/javascript">
    var user_cache = "<?php echo MessageCache::GetCurrentUserCache() ?>";
    var realplexor;

    $(function () {
        realplexor = new Dklab_Realplexor(
            "http://<?php echo Yii::app()->comet->host ?>",
            "<?php echo Yii::app()->comet->namespace ?>"
        );

        realplexor.subscribe(user_cache, function (result, id) {
            console.log(result);
            if (result.type == <?php echo UserSignal::SIGNAL_TAKEN ?>) {
                AddExecutor(result.id.$id);
            }
            if (result.type == <?php echo UserSignal::SIGNAL_DECLINE ?>) {
                RemoveExecutor(result.id.$id);
            }
            if (result.type == <?php echo UserSignal::SIGNAL_UPDATE ?>) {
                UpdateTable();
            }
            if (result.type == <?php echo UserSignal::SIGNAL_EXECUTED ?>) {
                TaskExecuted(result.id.$id);
            }
        });
        realplexor.execute();

        $('body').delegate('a.take-task', 'click', function () {
            var id = $(this).prev().val();
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/club/signals/take") ?>',
                data:{id:id},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status == 1) {
                        var id = $(this).prev().val();
                        $(this).hide();
                        $(this).next().show();
                        $.pnotify({
                            pnotify_text: 'Вы взяли задание. Приступите к его выполнению.'
                        });
                    } else {
                        if (response.status == 2) {
                            $.pnotify({
                                pnotify_title:'<?php echo Yii::t('app', 'Ошибка');?>',
                                pnotify_type:'error',
                                pnotify_text:'Уже достаточно человек на задание'
                            });
                        }
                    }
                },
                context:$(this)
            });
            return false;
        });

        $('body').delegate('a.decline-task', 'click', function () {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/club/signals/decline") ?>',
                data:{id:$(this).parents('td.actions').find('input').val()},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status == 1) {
                        $(this).parent().hide();
                        $(this).parent().prev().show();
                    }
                },
                context:$(this)
            });
            return false;
        });
    });

    function AddExecutor(id) {
        var count = parseInt($('#signal' + id + ' .executors').html()) + 1;
        var max = parseInt($('#signal' + id + ' .need').html());
        $('#signal' + id + ' .executors').html(count);
        if (count >= max) {
            $('#signal' + id).addClass('full');
        }
    }

    function RemoveExecutor(id) {
        var count = parseInt($('#signal' + id + ' .executors').html()) - 1;
        var max = parseInt($('#signal' + id + ' .need').html());
        $('#signal' + id + ' .executors').html(count);
        if (count < max) {
            $('#signal' + id).removeClass('full');
        }
    }

    function UpdateTable() {
        $.ajax({
            url: '<?php echo Yii::app()->createUrl("/club/signals/index") ?>',
            type: 'POST',
            success: function(response) {
                $('.grid-view').html(response);
            }
        });
    }

    function TaskExecuted(id) {
        $('#signal' + id + ' .taken').hide();
        $('#signal' + id + ' .take-task').hide();
        $('#signal' + id + ' .executed').show();
    }
</script>
<div class="grid-view">
    <?php $this->renderPartial('_data', array('models' => $models)); ?>
</div>