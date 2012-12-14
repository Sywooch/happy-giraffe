<div class="best-users tabs">
    <div class="best-users_title">Лучшие <?=($this->type == $this::TYPE_CLUBS) ? 'клабберы' : 'блоггеры'?></div>
    <div class="best-users_nav">
        <ul>
            <li class="best-users_nav_item active"><a  onclick="setTab(this, 1);" href="javascript:void(0);"><span>Сегодня</span></a></li>
            <li class="best-users_nav_item"><a  onclick="setTab(this, 2);" href="javascript:void(0);"><span>Неделя</span></a></li>
            <li class="best-users_nav_item"><a onclick="setTab(this, 3);" href="javascript:void(0);"><span>Месяц</span></a></li>
        </ul>
    </div>
    <div class="tabs-container">
        <div class="tab-box tab-box-1" style="display:block">
            <table class="best-users_list" cellspacing="0" cellpadding="0">
                <tr>
                    <th class="best-users_list-rank"></th>
                    <th class="best-users_list-ava"></th>
                    <th class="best-users_list-post">Тем</th>
                    <th class="best-users_list-comment"><i class="icon-comment"></i></th>
                    <th class="best-users_list-point">Баллов</th>
                </tr>
                <?php foreach ($day as $k => $r): ?>
                    <tr>
                        <td class="best-users_list-rank"><i class="rank rank<?=($k+1)?>"></i></td>
                        <td class="best-users_list-ava">
                            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                'user' => $users[$r['id']],
                                'small' => true,
                                'size' => 'small',
                            )); ?>
                        </td>
                        <td class="best-users_list-post"><?=$r['cCount']?></td>
                        <td class="best-users_list-comment"><?=$r['cmCount']?></td>
                        <td class="best-users_list-point"><?=$r['rating']?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="tab-box tab-box-2">
            <table class="best-users_list" cellspacing="0" cellpadding="0">
                <tr>
                    <th class="best-users_list-rank"></th>
                    <th class="best-users_list-ava"></th>
                    <th class="best-users_list-post">Тем</th>
                    <th class="best-users_list-comment"><i class="icon-comment"></i></th>
                    <th class="best-users_list-point">Баллов</th>
                </tr>
                <?php foreach ($week as $k => $r): ?>
                    <tr>
                        <td class="best-users_list-rank"><i class="rank rank<?=($k+1)?>"></i></td>
                        <td class="best-users_list-ava">
                            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                'user' => $users[$r['id']],
                                'small' => true,
                                'size' => 'small',
                            )); ?>
                        </td>
                        <td class="best-users_list-post"><?=$r['cCount']?></td>
                        <td class="best-users_list-comment"><?=$r['cmCount']?></td>
                        <td class="best-users_list-point"><?=$r['rating']?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="tab-box tab-box-3">
            <table class="best-users_list" cellspacing="0" cellpadding="0">
                <tr>
                    <th class="best-users_list-rank"></th>
                    <th class="best-users_list-ava"></th>
                    <th class="best-users_list-post">Тем</th>
                    <th class="best-users_list-comment"><i class="icon-comment"></i></th>
                    <th class="best-users_list-point">Баллов</th>
                </tr>
                <?php foreach ($month as $k => $r): ?>
                    <tr>
                        <td class="best-users_list-rank"><i class="rank rank<?=($k+1)?>"></i></td>
                        <td class="best-users_list-ava">
                            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $users[$r['id']],
                            'small' => true,
                            'size' => 'small',
                        )); ?>
                        </td>
                        <td class="best-users_list-post"><?=$r['cCount']?></td>
                        <td class="best-users_list-comment"><?=$r['cmCount']?></td>
                        <td class="best-users_list-point"><?=$r['rating']?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>