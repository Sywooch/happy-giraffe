<?php
/**
 * @var \site\frontend\modules\specialists\modules\pediatrician\widgets\stats\SummaryWidget $this
 * @var int $usersCount
 * @var int $likesCount
 */
?>

<div class="landing-question pediator">
    <div class="statistik statistik--style">
        <div class="statistik__header statistik__header--style">
            <div class="pediator__header-left">
                <div class="statistik__text statistik__text--big statistik__text--grey display-ib margin-r15"><?=$usersCount?></div>
                <div class="statistik__text statistik__text--small statistik__text--grey display-ib"><?=Str::GenerateNoun(['пользователь', 'пользователя', 'пользователей'], $usersCount)?> уже<br>получили вашу помощь</div>
            </div>
            <div class="pediator__header-right">
                <div class="statistik__ico statistik__ico--roze display-ib verticalalign-m margin-r9"></div>
                <div class="statistik__text statistik__text--big statistik__text--green display-ib margin-r15"><?=$likesCount?></div>
                <div class="statistik__text statistik__text--small statistik__text--grey display-ib"><?=Str::GenerateNoun(['раз', 'раза', 'раз'], $likesCount)?> вам сказали<br>Спасибо!</div>
            </div>
        </div>
    </div>
</div>