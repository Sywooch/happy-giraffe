<?php
/* @var $this Controller
 * @var $service Service
 */
$users = $service->getLastUsers();
$user_count = $service->getUsersCount();
?><div class="assistance-users">
    <div class="assistance_text">Последние, кто воспользовались сервисом:</div>
    <ul class="assistance-users_list clearfix"<?php
        if (count($users) < 10 ) echo ' style="width:'.(count($users)*33).'px;"';
        elseif (count($users) < 19 ) echo ' style="width:'.(ceil(count($users)/2)*33).'px;"';
        ?>>
        <?php foreach ($users as $user): ?>
            <li class="assistance-users_list-item">
                <?php $this->widget('Avatar', array('user' => $user, 'size' => Avatar::SIZE_MICRO)); ?>
            </li>
        <?php endforeach; ?>
        <?php if ($user_count > 20):?>
            <span class="assistance-users_other">и еще <?=($user_count - 20) ?></span>
        <?php endif ?>
    </ul>
</div>