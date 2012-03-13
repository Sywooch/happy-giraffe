<?php
/* @var $this CController
 * @var $history UserSignalResponse[]
 */
?>
<ol>
    <?php foreach ($history as $model): ?>
    <li>
        <div class="text"><?php echo $model->signal()->getHistoryText() ?></div>
        <div class="date"><?php echo date("H:i", $model->time) ?></div>
    </li>
    <?php endforeach; ?>
</ol>