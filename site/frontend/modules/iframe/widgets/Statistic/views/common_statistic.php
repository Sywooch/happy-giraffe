<?php
/**
 * @var integer $votes
 * @var integer $answers
 */
?>
<div class="b-text--left b-margin--bottom_40">
    <div class="b-user-box b-user-box--yellow b-user-box-iframe">
        <?=$my_statistic?'<div class="b-user-box-iframe_title">Моя статистика</div>':'';?>
        <div class="b-user-box-table">
            <div class="b-user-box__item">
                <div class="b-user-box__num b-user-box__num--black"><?=$answers?></div>
                <div class="b-user-box__text">мам уже<br/>получили помощь</div>
            </div>
            <div class="b-user-box__item">
                <div class="b-user-box__num b-user-box__num--green b-user-box__num--position"><?=$votes?></div>
                <div class="b-user-box__text">раз уже сказали<br>Спасибо!</div>
            </div>
        </div>
    </div>
</div>