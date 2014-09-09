<?php $time = $this->time;
$last_time = $this->last_time;
//echo date("Y-m-d", $this->time).'<br>';
//echo date<!--("Y-m-d", $this->last_time);-->
?>
<div class=" col-1 morning-sidebar">

    <div class="banner">
        <img src="/images/morning_sidebar_banner.png">
    </div>

    <div class="calendar">

        <div class="clearfix">
            <div class="days">
                <table>
                    <thead>
                    <tr>
                        <td colspan="3"><?=HDate::ruMonth(date("m", $time)) ?></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $days_away = round((strtotime(date("Y-m-d 00:00:00", $this->last_time)) - $time) / (24 * 3600));
                    if ($days_away > 3) {
                        ?>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-4 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-4 days', $time)))) ?>"><?=date("j", strtotime('-4 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-4 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-3 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-3 days', $time)))) ?>"><?=date("j", strtotime('-3 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-3 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-2 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-2 days', $time)))) ?>"><?=date("j", strtotime('-2 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-2 days', $time))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-1 day', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-1 day', $time)))) ?>"><?=date("j", strtotime('-1 day', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-1 day', $time))?></td>
                        <?php endif ?>
                            <td class="active"><a href="javascript:void(0);"><?=date("j", $time)?></a></td>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+1 day', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('+1 day', $time)))) ?>"><?=date("j", strtotime('+1 day', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+1 day', $time))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+2 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('+2 days', $time)))) ?>"><?=date("j", strtotime('+2 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+2 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+3 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('+3 days', $time)))) ?>"><?=date("j", strtotime('+3 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+3 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+4 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('+4 days', $time)))) ?>"><?=date("j", strtotime('+4 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+4 days', $time))?></td>
                        <?php endif ?>
                    </tr>
                        <?php
                    } else {

                        ?>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-8 days', $last_time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-8 days', $last_time)))) ?>"><?=date("j", strtotime('-8 days', $last_time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-8 days', $last_time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-7 days', $last_time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-7 days', $last_time)))) ?>"><?=date("j", strtotime('-7 days', $last_time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-7 days', $last_time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-6 days', $last_time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-6 days', $last_time)))) ?>"><?=date("j", strtotime('-6 days', $last_time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-6 days', $last_time))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-5 days', $last_time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-5 days', $last_time)))) ?>"><?=date("j", strtotime('-5 days', $last_time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-5 days', $last_time))?></td>
                        <?php endif ?>

                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-4 days', $last_time)))):?>
                            <td><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-4 days', $last_time)))) ?>"><?=date("j", strtotime('-4 days', $last_time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-4 days', $last_time))?></td>
                        <?php endif ?>

                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-3 days', $last_time)))):?>
                            <td<?php if (date("j", strtotime('-3 days', $last_time)) == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-3 days', $last_time)))) ?>"><?=date("j", strtotime('-3 days', $last_time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-3 days', $last_time))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-2 days', $last_time)))):?>
                        <td<?php if (date("j", strtotime('-2 days', $last_time)) == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-2 days', $last_time)))) ?>"><?=date("j", strtotime('-2 days', $last_time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-2 days', $last_time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-1 day', $last_time)))):?>
                        <td<?php if (date("j", strtotime('-1 day', $last_time)) == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-1 days', $last_time)))) ?>"><?=date("j", strtotime('-1 days', $last_time))?></a></td>
                        <?php else: ?>
                             <td><?=date("j", strtotime('-1 day', $last_time))?></td>
                        <?php endif ?>
                        <td<?php if (date('j', $last_time) == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('/morning/index', array('date'=>date("Y-m-d", $last_time))) ?>"><?=date("j", $last_time)?></a></td>
                    </tr>
                        <?php
                    }
                    ?>
                    </tbody>

                </table>
            </div>
            <div class="date">
                <span><?=(date("j", $time)) ?></span><?=HDate::ruMonthShort(date("m", $time)) ?>
            </div>
        </div>
        <div class="nav">
            <?php //check if there is news on previous day
            $prev_day = date("Y-m-d", strtotime('-1 day', $this->time));
            $criteria = new CDbCriteria;
            $criteria->condition = 'type_id=4 AND created >= "' . $prev_day . ' 00:00:00"' . ' AND created <= "' . $prev_day . ' 23:59:59" AND is_published = 1';
            $prev_day_news_count = CommunityContent::model()->with('morning')->count($criteria);

            ?>
            <input type="hidden" value="<?=date("Y-m-d", $this->time)  ?>">
            <a href="<?= ($prev_day_news_count == 0)?'javascript:void(0);':$this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('-1 day', $this->time)))) ?>" class="prev" onclick="return Morning.next()"></a>
            <a href="<?= ($days_away == 0)?'javascript:void(0);':$this->createUrl('/morning/index', array('date'=>date("Y-m-d", strtotime('+1 day', $this->time)))) ?>" class="next" onclick="return Morning.prev()"></a>
        </div>
    </div>

    <div id="checkpoint"></div>

</div>