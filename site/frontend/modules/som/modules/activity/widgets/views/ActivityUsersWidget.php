<?php
/**
 * @var User[] $users
 */
?>

<div class="readers2 readers2__no-btn readers2__m">
    <div class="readers2_t-sm heading-small">
        <span class="icon-status icon-status__small icon-status__status-online"></span>
        Сейчас на сайте <?php /*count($onlineUsers)*/  ?>
    </div>
    <ul class="readers2_ul clearfix">
        <?php foreach ($users as $user): ?>
            <li class="readers2_li clearfix">
                <?php $this->widget('Avatar', array('user' => $user, 'size' => 40)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="readers2_sub-tx">и еще много <span class="readers2_smile"></span>!!!</div>
</div>