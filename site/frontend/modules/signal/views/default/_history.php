<?php
/* @var $this CController
 * @var $history UserSignalResponse[]
 */
?>
<ol>
    <?php foreach ($history as $model): ?>
    <?php $signal = $model->signal() ?>
    <?php if (isset($signal)):?>
        <li>
            <div class="text"><?php echo $signal->getHistoryText() ?></div>
            <div class="date"><?php echo date("H:i", $model->time) ?></div>
        </li>
    <?php endif ?>
    <?php endforeach; ?>
</ol>