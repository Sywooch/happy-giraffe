<?php
/* @var $this Controller
 * @var $zodiac int
 */
?><li>
    <div class="img">
        <img src="/images/widget/horoscope/smaller/<?=$zodiac ?>.png">

        <div class="date"><span><?=Horoscope::model()->zodiac_list[$zodiac] ?></span><?=Horoscope::model()->someZodiacDates($zodiac) ?>
        </div>
    </div>
    <ul>
        <?php foreach (Horoscope::model()->zodiac_list as $key2 => $zodiac2): ?>
        <li><a href="<?=HoroscopeCompatibility::model()->getUrl($zodiac, $key2) ?>"><?=Horoscope::model()->zodiac_list[$zodiac] ?> - <?=$zodiac2 ?></a></li>
        <?php endforeach; ?>
    </ul>
</li>