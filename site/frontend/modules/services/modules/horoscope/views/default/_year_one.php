<div class="horoscope-day">
    <div class="ico-zodiac ico-zodiac__xl">
        <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
    </div>
    <div class="horoscope-day_tx"><?= $model->zodiacText() ?></div>
</div>
<div class="wysiwyg-content clearfix">
    <h2 class="horoscope-year-t horoscope-year-t__health">Здоровье</h2>
    <p><?=$model->health ?></p>
    <h2 class="horoscope-year-t horoscope-year-t__career">Карьера</h2>
    <p><?=$model->career ?></p>
    <h2 class="horoscope-year-t horoscope-year-t__fin">Финансы</h2>
    <p><?=$model->finance ?></p>
    <h2 class="horoscope-year-t horoscope-year-t__home">Личная жизнь</h2>
    <p><?=$model->personal ?></p>
</div>