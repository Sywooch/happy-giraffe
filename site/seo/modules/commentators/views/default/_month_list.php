<?php
/**
 * @var $this DefaultController
 * @var $month string выбранный месяц
 * @author Alex Kireev <alexk984@gmail.com>
 */

$months = array();
for ($i = 0; $i < 7; $i++){
    $time = strtotime('- ' . $i . ' month', strtotime(date("Y-m").'-15'));
    if ((date("Y", $time) == 2013 && date("m", $time) >= 3) || date("Y", $time) > 2013)
        $months [] = date("Y-m", $time);
}

?><div class="month-list clearfix">
    <ul class="month-list_ul">
        <?php foreach ($months as $menu_month): ?>
            <?php if (isset($params))
                $params['month']=$menu_month;
                else
                    $params = array('month'=>$menu_month);
            ?>
            <li class="month-list_li<?php if ($menu_month == $month) echo ' active' ?>">
                <a href="<?=$this->createUrl('', $params) ?>" class="month-list_i">
                    <span class="month-list_tx"><?= HDate::ruShortMonth(date("n", strtotime($menu_month.'-01'))).' '.date("Y", strtotime($menu_month.'-01'))?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>