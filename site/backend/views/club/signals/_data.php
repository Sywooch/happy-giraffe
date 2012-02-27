<?php
/* @var $this Controller
 * @var $models UserSignal[]
 */
?>
<table class="items">
    <thead>
    <tr>
        <th>Сигнал</th>
        <th>Пользователь</th>
        <th>Ссылка</th>
        <th>Действие</th>
        <th>Выполняют</th>
        <th>Нужно исполнителей</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $model): ?>
    <tr id="signal<?php echo $model->_id ?>" class="<?php
        if (count($model->executors)+count($model->success) >= $model->currentLimit()) echo 'full' ?>">
        <td><?php echo $model->signalType() ?></td>
        <td><?php echo $model->getUser()->getFullName() ?></td>
        <td><?php echo $model->getLink() ?></td>
        <td class="actions">
            <input type="hidden" value="<?php echo $model->_id ?>">
            <a href="#" class="take-task"<?php if (!$model->CurrentUserFree()) echo ' style="display:none;"' ?>>
                Взять на выполнение</a>
            <div class="taken"<?php if (!$model->CurrentUserIsExecutor()) echo ' style="display:none;"' ?>>
                <span>Взято вами на выполнение</span>
                <br>
                <a href="#" class="decline-task">Отказаться</a>
            </div>
            <div class="executed"<?php if (!$model->CurrentUserSuccessExecutor()) echo ' style="display:none;"' ?>>
                <span>Выполнено</span>
            </div>
        </td>
        <td class="executors"><?php echo count($model->executors)+count($model->success) ?></td>
        <td class="need"><?php echo $model->currentLimit() ?></td>
    </tr>
        <?php endforeach; ?>
    </tbody>
</table>