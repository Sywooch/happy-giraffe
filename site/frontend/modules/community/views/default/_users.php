<?php
$users = UserClubSubscription::model()->getSubscribers($this->club->id);
$user_count = UserClubSubscription::model()->getSubscribersCount($this->club->id);

?><div class="widget-friends clearfix">
    <div class="clearfix">
        <span class="heading-small">Участники клуба <?php if (false):?><span class="color-gray">(<?= $user_count ?>)</span><?php endif ?></span>
    </div>
    <ul class="widget-friends_ul clearfix">
        <?php foreach ($users as $user): ?>
            <li class="widget-friends_i">
                <?php $this->widget('Avatar', array('user' => $user)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>