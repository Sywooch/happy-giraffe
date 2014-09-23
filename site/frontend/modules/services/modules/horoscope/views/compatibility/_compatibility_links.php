<?php
/* @var $this Controller
 * @var $zodiac int
 */
?>
<li class="horoscope-compatibility-list_li">
    <div class="horoscope-compatibility-list_top">
        <div class="ico-zodiac ico-zodiac__s">
            <div class="ico-zodiac_in ico-zodiac__<?= $zodiac ?>"></div>
        </div>
    </div>
    <div class="menu-link-simple menu-link-simple__col">
        <ul class="menu-link-simple_ul">
            <?php foreach (Horoscope::model()->zodiac_list as $key2 => $zodiac2): ?>
                <li class="menu-link-simple_li">
                    <a class="menu-link-simple_a" href="<?= HoroscopeCompatibility::model()->getUrl($zodiac, $key2) ?>"><?= Horoscope::model()->zodiac_list[$zodiac] ?> - <?= $zodiac2 ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</li>