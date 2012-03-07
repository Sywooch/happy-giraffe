<?php
/* @var $this Controller
 * @var $models UserSignal[]
 */
?>
<table>
    <thead>
    <tr>
        <td colspan=2>Сигнал</td>
        <td>Что происходит?</td>
        <td>От кого</td>
        <td>Поймать</td>
        <td style="display: none;">Выполняют</td>
        <td style="display: none;">Нужно исполнителей</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $model): ?>
    <tr id="signal<?php echo $model->_id ?>" class="<?php
        if (count($model->executors) + count($model->success) >= $model->currentLimit()) echo 'full' ?>">
        <td class="icon"><i class="signal-icon <?php echo $model->getIcon() ?>"></td>
        <td class="name"><?php echo $model->signalType() ?></td>
        <td><?php echo $model->signalWant() ?></td>
        <td><?php echo $model->getUser()->getFullName() ?></td>
        <td class="actions">
            <input type="hidden" value="<?php echo $model->_id ?>">
            <a href="#" class="take-task btn btn-green-small"<?php
                if (!$model->CurrentUserFree()) echo ' style="display:none;"' ?>><span><span>Ок</span></span></a>

            <div class="taken"<?php if (!$model->CurrentUserIsExecutor()) echo ' style="display:none;"' ?>>
                <?php echo $model->getLink() ?> | <a href="" class="remove"></a>
            </div>
        </td>
        <td class="executors"
            style="display: none;"><?php echo count($model->executors) + count($model->success) ?></td>
        <td class="need" style="display: none;"><?php echo $model->currentLimit() ?></td>
    </tr>
        <?php endforeach; ?>
    </tbody>
</table>
