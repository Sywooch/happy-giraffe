<?php
/* @var $this Controller
 * @var $models UserSignal[]
 */
?>
<?php $this->renderPartial('_calendar', array()); ?>
<div class="title"><i class="icon"></i>Сигналы</div>

<div class="username">
    <i class="icon-status status-online"></i><span><?= Yii::app()->user->getModel()->getFullName() ?></span>
</div>

<div class="nav">
    <ul>
        <li class="active"><a href="" obj="">Все</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_POST ?>">Посты</a></li>
<!--        <li><a href="" obj="--><?php //echo UserSignal::TYPE_NEW_USER_POST ?><!--">Клубы</a></li>-->
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_VIDEO ?>">Видео</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_BLOG_POST ?>">Блоги</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_PHOTO ?>">Фото</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_REGISTER ?>">Гостевые</a></li>
    </ul>
</div>

<div class="clear"></div>

<?php $this->renderPartial('_data', array('models' => $models)); ?>

<?php $this->renderPartial('_history', array('history' => $history)); ?>

<script type="text/javascript">
    var filter = null;
    $(function () {
        $('body').delegate('a.take-task', 'click', function () {
            var id = $(this).prev().val();
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/signal/default/take") ?>',
                data:{id:id},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status == 1) {
                        var id = $(this).prev().val();
                        $(this).hide();
                        $(this).next().show();

                    } else {
                        if (response.status == 2) {

                        }
                    }
                },
                context:$(this)
            });
            return false;
        });

        $('body').delegate('a.remove', 'click', function () {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/signal/default/decline") ?>',
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

        $('.nav li a').click(function () {
            filter = $(this).attr('obj');
            $('.nav li').removeClass('active');
            $(this).parent().addClass('active');
            UpdateTable();
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
            url:'<?php echo Yii::app()->createUrl("/signal/default/index") ?>',
            type:'POST',
            data:{filter:filter},
            success:function (response) {
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