<?php
/**
 * @var int $visitors
 */
$visitorsLength = strlen($visitors);
?>

<div class="homepage_row">
    <div class="homepage-counter">
        <div class="homepage_title"> Нас посетило уже! </div>
        <div id="counter-users" class="counter-users">
            <?php
                for ($i = 0; $i < $visitorsLength; $i++):
                    $showOpening = ($i == 0) || (($visitorsLength - $i) % 3 == 0);
                    $showClosing = ($visitorsLength - $i - 1) % 3 == 0;
            ?>
                <?php if ($showOpening): ?><div class="counter-users_dash"><?php endif; ?>
                        <div class="counter-users_digit"><?=substr($visitors, $i, 1)?></div>
                <?php if ($showClosing): ?></div><?php endif; ?>
            <?php endfor; ?>
        </div>
        <div class="homepage_desc-tx">будущих и настоящих мам и пап</div><a href="#registerWidget" class="homepage_btn-sign btn btn-success btn-xxl popup-a">Присоединяйся!</a>
    </div>
</div>