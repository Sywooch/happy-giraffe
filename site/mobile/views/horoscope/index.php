<div class="horoscope">
    <h1 class="horoscope_h1">Гороскоп по знакам Зодиака</h1>
    <div class="horoscope-list clearfix">
        <ul class="horoscope-list_ul clearfix">
            <?php foreach ($models as $m): ?>
                <li class="horoscope-list_li horoscope-list_li__active">
                    <a href="<?=$this->createUrl('view', array('zodiac' => $m->getZodiacSlug()))?>" class="horoscope-list_i">
                                <span class="horoscope-list_img">
                                    <img src="/images/services/horoscope/medium/<?=$m->zodiac?>.png" alt="" />
                                </span>
                        <span class="horoscope-list_desc"><?=$m->zodiacText()?></span>
                        <span class="horoscope-list_date"><?=$m->zodiacDates()?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>