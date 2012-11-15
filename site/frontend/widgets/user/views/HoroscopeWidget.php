<?php
/* @var $this Controller
 * @var $horoscope Horoscope
 * @var $show_horoscope bool
 */
?>
<?php if (!$show_horoscope): ?>
<div class="user-horoscope-prev">
    <div class="user-horoscope-prev_holder">
        <div class="clearfix">
            <div class="user-horoscope-prev_img"><img src="/images/widget/horoscope/big/<?=$horoscope->zodiac ?>.png">
            </div>
            <div class="user-horoscope-prev_title"><?=$horoscope->zodiacText() ?>
                <br><em><?=$horoscope->zodiacDates() ?></em></div>
        </div>
        <div class="user-horoscope-prev_date"><?=date("d")?> <span><?=HDate::ruMonthShort(date('n')) ?></span></div>
        <div class="btn-green twolines" onclick="Horoscope.show()">
            <span class="big">Посмотреть</span>
            <span class="small">гороскоп</span>
        </div>
    </div>
</div>
<?php endif ?>

<div class="user-horoscope-2"<?php if (!$show_horoscope) echo ' style="display: none;"'?>>

    <div class="title-row clearfix">
        <div class="user-horoscope-2_img"><img src="/images/widget/horoscope/middle/<?=$horoscope->zodiac ?>.png"></div>
        <div class="user-horoscope-2_date"><?=date("d")?> <span><?=HDate::ruMonthShort(date('n')) ?></span></div>
        <div class="user-horoscope-2_title"><?=$horoscope->zodiacText() ?><br><em><?=$horoscope->zodiacDates() ?></em>
        </div>
    </div>

    <p><?=$horoscope->text ?></p>

    <div class="user-horoscope-2_likes">
        <div class="user-horoscope-2_likes-title">Отметь, если понравился!</div>
        <div class="custom-likes-small" style="height: 35px;">
            <iframe src="/services/horoscope/default/likes/" frameborder="0">

            </iframe>
        </div>
    </div>

    <div class="user-horoscope-2_tomorrow">
        <div class="icon-zodiac"><img src="/images/widget/horoscope/icon-h36/<?=$horoscope->zodiac ?>.png"></div>
        <a href="<?=Yii::app()->createUrl('/services/horoscope/default/tomorrow', array('zodiac' => $horoscope->getZodiacSlug())) ?>">Узнай
            что будет завтра</a>
    </div>

</div>