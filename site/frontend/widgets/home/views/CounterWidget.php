<?php
/**
 * @var int $visitors
 */
$visitorsLength = strlen($visitors);
?>

<div id="counter-users" class="counter-users">
    <?php
        for ($i = 0; $i < $visitorsLength; $i++):
            $showOpening = ($i == 0) || (($visitorsLength - $i) % CounterWidget::DIGITS_PER_SECTION == 0);
            $showClosing = ($visitorsLength - $i - 1) % CounterWidget::DIGITS_PER_SECTION == 0;
    ?>
        <?php if ($showOpening): ?><div class="counter-users_dash"><?php endif; ?>
                <div class="counter-users_digit"><?=substr($visitors, $i, 1)?></div>
        <?php if ($showClosing): ?></div><?php endif; ?>
    <?php endfor; ?>
</div>