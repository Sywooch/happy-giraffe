<div class="horoscope-day">
    <div class="ico-zodiac ico-zodiac__xl">
        <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
    </div>
    <div class="horoscope-day_tx"><?= $model->zodiacText() ?></div>
</div>
<div class="wysiwyg-content clearfix">
    <?php
    echo Str::strToParagraph($model->text);
    ?>
</div>
