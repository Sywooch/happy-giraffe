<!-- Зодиаки-->
<ul class="zodiac-list_ul">
    <?php
    $this->beginClip('item');
    ?>
    <li class="zodiac-list_li">
        <a class="zodiac-list_a" href="{url}">
            <div class="ico-zodiac ico-zodiac__s ico-zodiac__m-xs<?= (isset($sidebar) ? ' ico-zodiac__s-md' : '') ?>">
                <div class="ico-zodiac_in ico-zodiac__{index}"></div>
            </div>
            <div class="zodiac-list_tx">
                {text}
            </div>
        </a>
    </li>
    <?php
    $this->endClip();
    $list = Horoscope::model()->zodiac_list;
    foreach ($list as $i => $name)
        $this->renderClip('item', array(
            '{url}' => $this->getUrl(array('zodiac' => Horoscope::model()->zodiac_list_eng[$i])),
            '{index}' => $i,
            '{text}' => $name,
        ));
    ?>
</ul>