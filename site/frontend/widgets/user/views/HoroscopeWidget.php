<?php
/* @var $this Controller
 * @var $forecast Horoscope
 */
?><div class="user-horoscope">

    <div class="clearfix">
        <div class="title"><?= $forecast->zodiac_list[$forecast->zodiac] ?></div>
        <div class="img"><img src="/images/widget/horoscope/<?= $forecast->zodiac ?>.png"></div>
        <div class="date"><?=date('j')?><span class="date"><?=Yii::app()->dateFormatter->format('MMM', time())?></span></div>
    </div>

    <p><?= str_replace("\n", '</p><p>', $forecast->text) ?></p>

</div>