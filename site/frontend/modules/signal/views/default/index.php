<?php
/* @var $this Controller
 * @var $models UserSignal[]
 */

$this->renderPartial('_style',array()); ?>
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

        $('body').delegate('a.decline-task', 'click', function () {
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

        $('table.choose-type a').click(function(){
            filter = $(this).attr('obj');
            $('table.choose-type td').removeClass('active');
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
            url: '<?php echo Yii::app()->createUrl("/signal/default/index") ?>',
            type: 'POST',
            data:{filter:filter},
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
<table class="choose-type">
    <tr>
        <td class="active"><a href="#" obj="">все события</a></td>
        <td><a href="#" obj="<?php echo UserSignal::TYPE_NEW_USER_POST ?>">только посты</a></td>
        <td><a href="#" obj="<?php echo UserSignal::TYPE_NEW_USER_VIDEO ?>">только видео</a></td>
    </tr>
</table>
<div class="grid-view">
    <?php $this->renderPartial('_data', array('models' => $models,'history'=> $history)); ?>
</div>