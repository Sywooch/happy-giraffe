<?php
$k = 0;

?><table class="best-users_list" cellspacing="0" cellpadding="0">
    <tr>
        <th class="best-users_list-rank"></th>
        <th class="best-users_list-ava"></th>
        <th class="best-users_list-post">Тем</th>
        <th class="best-users_list-comment"><i class="icon-comment"></i></th>
        <th class="best-users_list-point">Баллов</th>
    </tr>
    <?php foreach ($list as $user_id => $value): ?>
    <tr>
        <td class="best-users_list-rank"><i class="rank rank<?=($k+1)?>"></i></td>
        <td class="best-users_list-ava">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $users[$user_id],
            'small' => true,
            'size' => 'small',
        )); ?>
        </td>
        <td class="best-users_list-post"><?=$value['cCount']?></td>
        <td class="best-users_list-comment"><?=$value['cmCount']?></td>
        <td class="best-users_list-point"><?=$value['rating']?></td>
    </tr>
    <?php endforeach; ?>
</table>