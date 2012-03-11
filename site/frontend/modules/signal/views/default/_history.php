<?php
/* @var $this CController
 * @var $history UserSignal[]
 */
?>
<ol>
    <?php foreach ($history as $model): ?>
    <li>
        <div class="text"><?php echo $model->getHistoryText() ?></div>
        <div class="date"><?php echo $model->created_time ?></div>
    </li>
    <?php endforeach; ?>
</ol>