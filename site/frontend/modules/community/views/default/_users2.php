<?php

$users = UserClubSubscription::model()->getSubscribers($this->club->id, 6);
$user_count = UserClubSubscription::model()->getSubscribersCount($this->club->id);
?><div class="readers2 js-community-subscription" style="display: none" data-bind="visible: true">
    <a class="btn-green btn-medium" href="" data-bind="click: subscribe, visible: !active()">Вступить в клуб</a>
    <ul class="readers2_ul clearfix">
        <?php foreach ($users as $user): ?>
            <li class="readers2_li clearfix">
                <?php $this->widget('Avatar', array('user' => $user, 'size' => Avatar::SIZE_MICRO)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="clearfix">
        <div class="readers2_count">Все участники клуба (<!-- ko text: count --><!-- /ko -->)</div>
    </div>
</div>