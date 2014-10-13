<div class="horoscope-fast-list clearfix">

    <ul>
        <li>
            <div class="other">Смотреть другие знаки</div>
        </li>
        <?php for ($i = 1; $i <= 12; $i++) if ($i != $model->zodiac) { ?>
        <li>
            <?= HHtml::link('<img src="/images/widget/horoscope/small/'.$i.'.png"><br><span>'.
            Horoscope::getZodiacTitle($i).'</span><br> '. $model->someZodiacDates($i),
            $model->getOtherZodiacUrl(Horoscope::model()->getZodiacSlug($i)),
            array('title'=>$model->getOtherZodiacTitle($i)), true) ?>
        </li>
        <?php } ?>
    </ul>

</div>