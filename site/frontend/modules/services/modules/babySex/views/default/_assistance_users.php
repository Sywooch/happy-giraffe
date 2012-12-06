<?php
/* @var $this Controller
 * @var $service Service
 */
$count = $service->usersCount();
$users = $service->getLastUsers();
?><div class="assistance-users">
    <div class="assistance_text">Последние, кто воспользовались сервисом:</div>
    <ul class="assistance-users_list clearfix">
        <?php foreach ($users as $user): ?>
            <li class="assistance-users_list-item">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $user,
                'size' => 'small',
                'small' => true,
            )); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if ($count > 20):?>
        <span class="assistance-users_other">и еще <?=$count-20 ?></span>
    <?php endif ?>
</div>