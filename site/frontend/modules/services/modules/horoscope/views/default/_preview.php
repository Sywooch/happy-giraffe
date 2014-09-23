<?php
/* @var $this Controller
 * @var $model Horoscope
 */
if (isset($model))
{
    ?>
    <li class="zodiac-list_li"><a class="zodiac-list_a" href="<?= $model->getMainUrl() ?>">
            <div class="ico-zodiac ico-zodiac__s ico-zodiac__m-xs">
                <div class="ico-zodiac_in ico-zodiac__<?= $model->zodiac ?>"></div>
            </div>
            <div class="zodiac-list_tx">
                <?= $model->zodiacText() ?>
            </div>
        </a>
    </li>
    <?php
}