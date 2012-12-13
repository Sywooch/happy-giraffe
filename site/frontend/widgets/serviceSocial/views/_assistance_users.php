<?php
/* @var $this Controller
 * @var $service Service
 */
$users = $service->getLastUsers();
?><div class="assistance-users">
    <div class="assistance_text">Последние, кто воспользовались сервисом:</div>
    <ul class="assistance-users_list clearfix"<?php
        if (count($users) < 10 ) echo ' style="width:'.(count($users)*33).'px;"';
        elseif (count($users) < 19 ) echo ' style="width:'.(ceil(count($users)/2)*33).'px;"';
        ?>>
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
</div>