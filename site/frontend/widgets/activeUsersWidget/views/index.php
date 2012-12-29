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
            <?php $this->render('list', array('list' => $day, 'users' => $users)); ?>
        </div>

        <div class="tab-box tab-box-2">
            <?php $this->render('list', array('list' => $week, 'users' => $users)); ?>
        </div>

        <div class="tab-box tab-box-3">
            <?php $this->render('list', array('list' => $month, 'users' => $users)); ?>
        </div>
    </div>
</div>