<div>
    <h2>Регистрации за последние дни</h2>
    <?php for ($i = 0; $i < 10; $i++) {
    $date = date("Y-m-d", strtotime('-' . $i . ' days'));
    $condition = 'register_date >= "' . $date . ' 00:00:00" AND register_date <= "' . $date . ' 23:59:59";';

    $regs_count = Yii::app()->db->createCommand()->select('count(id)')->from('users')->where($condition)->queryScalar();

    $ips = Yii::app()->db->createCommand()->select('last_ip')->from('users')->where($condition)->queryColumn();
    if (count($ips) > 0)
        $percent = round(100 * count(array_unique($ips)) / count($ips));
    else
        $percent = 100;
    ?>
    <div>
        <span><?=$date ?>&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$regs_count ?> : <?=$percent ?>%</span>
    </div><?php } ?>
</div>
<div>
    <h2>Регистраций с одноклассников</h2>

    <?php for ($i = 0; $i < 10; $i++) {
    $date = date("Y-m-d", strtotime('-' . $i . ' days'));
    $regs_count = Yii::app()->db->createCommand('select count(users.id) from users left join user__social_services as serv ON users.id = serv.user_id where register_date >= "' . $date . ' 00:00:00" AND register_date <= "' . $date . ' 23:59:59" AND serv.service = "odnoklassniki" ;')->queryScalar();
    ?>
    <div>
        <span><?=$date ?>&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$regs_count ?></span>
    </div><?php } ?>
</div>
<div>
    <h2>Сколько сегодня зашло зарегистрированных пользователей</h2>
    <?php
    $today = date("Y-m-d") . ' 00:00:00';
    echo User::model()->count('last_active >= "' . $today . '"') . '<br>';
    ?>
</div>