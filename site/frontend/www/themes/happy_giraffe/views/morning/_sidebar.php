<?php $time = $this->time; ?>
<div class="morning-sidebar">

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
                    $days_away = round((strtotime(date("Y-m-d 00:00:00")) - $time) / (24 * 3600));
                    if ($days_away > 3) {
                        ?>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-4 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-4 days', $time)))) ?>"><?=date("j", strtotime('-4 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-4 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-3 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-3 days', $time)))) ?>"><?=date("j", strtotime('-3 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-3 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-2 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-2 days', $time)))) ?>"><?=date("j", strtotime('-2 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-2 days', $time))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-1 day', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-1 day', $time)))) ?>"><?=date("j", strtotime('-1 day', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-1 day', $time))?></td>
                        <?php endif ?>
                            <td class="active"><a href="javascript:void(0);"><?=date("j", $time)?></a></td>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+1 day', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('+1 day', $time)))) ?>"><?=date("j", strtotime('+1 day', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+1 day', $time))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+2 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('+2 days', $time)))) ?>"><?=date("j", strtotime('+2 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+2 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+3 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('+3 days', $time)))) ?>"><?=date("j", strtotime('+3 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+3 days', $time))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('+4 days', $time)))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('+4 days', $time)))) ?>"><?=date("j", strtotime('+4 days', $time))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('+4 days', $time))?></td>
                        <?php endif ?>
                    </tr>
                        <?php
                    } else {

                        ?>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-8 days')))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-8 days')))) ?>"><?=date("j", strtotime('-8 days'))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-8 days'))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-7 days')))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-7 days')))) ?>"><?=date("j", strtotime('-7 days'))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-7 days'))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-6 days')))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-6 days')))) ?>"><?=date("j", strtotime('-6 days'))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-6 days'))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-5 days')))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-5 days')))) ?>"><?=date("j", strtotime('-5 days'))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-5 days'))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-4 days')))):?>
                            <td><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-4 days')))) ?>"><?=date("j", strtotime('-4 days'))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-4 days'))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-3 days')))):?>
                        <td<?php if (date("j", strtotime('-3 days')) == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-3 days')))) ?>"><?=date("j", strtotime('-3 days'))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-3 days'))?></td>
                        <?php endif ?>
                    </tr>
                    <tr>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-2 days')))):?>
                        <td<?php if (date("j", strtotime('-2 days')) == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-2 days')))) ?>"><?=date("j", strtotime('-2 days'))?></a></td>
                        <?php else: ?>
                            <td><?=date("j", strtotime('-2 days'))?></td>
                        <?php endif ?>
                        <?php if ($this->hasArticlesOnDay(date("Y-m-d", strtotime('-1 day')))):?>
                        <td<?php if (date("j", strtotime('-1 day')) == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-1 days')))) ?>"><?=date("j", strtotime('-1 days'))?></a></td>
                        <?php else: ?>
                             <td><?=date("j", strtotime('-1 day'))?></td>
                        <?php endif ?>
                        <td<?php if (date('j') == date("j", $time)) echo ' class="active"'
                            ?>><a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d"))) ?>"><?=date("j", time())?></a></td>
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
            <input type="hidden" value="<?=date("Y-m-d", $time)  ?>">
            <a href="<?= $this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('-1 day', $time)))) ?>" class="prev" onclick="return Morning.next()"></a>
            <a href="<?= ($days_away == 0)?'javascript:void(0);':$this->createUrl('morning/index', array('date'=>date("Y-m-d", strtotime('+1 day', $time)))) ?>" class="next" onclick="return Morning.prev()"></a>
        </div>
    </div>

    <div id="checkpoint"></div>

</div>