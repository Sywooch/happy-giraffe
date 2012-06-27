<div>
    <h2>Регистрации за последние дни</h2>
    <?php for($i=0;$i<10;$i++){
    $date = date("Y-m-d", strtotime('-'.$i.' days'));
    $regs_count = Yii::app()->db->createCommand('select count(id) from users where register_date >= "'.$date.' 00:00:00" AND register_date <= "'.$date.' 00:00:00";')->queryScalar();
    ?><div>
        <span><?=$date ?>&nbsp;&nbsp;&nbsp;&nbsp;</span><span><?=$regs_count ?></span>
    </div><?php } ?>
</div>