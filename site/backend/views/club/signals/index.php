<?php
/* @var $this Controller
 * @var $models UserSignal[]
 */
?>
<style type="text/css">
    .grid-view {
        padding: 15px 0;
    }

    .grid-view table.items {
        background: none repeat scroll 0 0 white;
        border: 1px solid #D0E3EF;
        border-collapse: collapse;
        width: 100%;
    }

    .grid-view table.items th, .grid-view table.items td {
        font-size: 0.9em;
        padding: 0.3em;
    }

    .grid-view table.items th {
        font-weight: bold;
        text-decoration: none;
        padding-bottom: 10px;
    }

    .grid-view table.items th a:hover {
        color: #FFFFFF;
    }

    .grid-view table.items tr:hover {
        background: none repeat scroll 0 0 #ECFBD4;
    }

    a.decline-task {
        color: #a10600;
    }

    .actions span {
        color: #00b522;
    }
</style>
<script type="text/javascript">
    $(function () {
        $('a.take-task').click(function () {
            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/club/signals/take") ?>',
                data:{id:$(this).prev().val()},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status == 1) {
                        $('.taken').show();
                        $(this).hide();
                    } else {
                        if (response.status == 2) {

                        }
                    }
                },
                context:$(this)
            });
            return false;
        });
    });
</script>
<div class="grid-view">
    <table class="items">
        <thead>
        <tr>
            <th>Сигнал</th>
            <th>Пользователь</th>
            <th>Ссылка</th>
            <th>Действие</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($models as $model): ?>
        <tr>
            <td><?php echo $model->signalType() ?></td>
            <td><?php echo $model->getUser()->getFullName() ?></td>
            <td><?php echo $model->getLink() ?></td>
            <td class="actions">
                <input type="hidden" value="<?php echo $model->_id ?>">
                <a href="#" class="take-task">Взять на выолнение</a>

                <div class="taken">
                    <span>Взято вами на выполнение</span>
                    <br>
                    <a href="#" class="decline-task">Отказаться</a>
                </div>
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>