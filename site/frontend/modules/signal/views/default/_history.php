<?php
/* @var $this CController
 * @var $history UserSignal[]
 */
?>
<div class="fast-list">

    <ol>
        <?php foreach ($history as $model): ?>
        <li>
            <div class="text"><?php echo $model->getHistoryText() ?></div>
            <div class="date"><?php echo $model->created ?></div>
        </li>
        <?php endforeach; ?>
    </ol>

</div>

