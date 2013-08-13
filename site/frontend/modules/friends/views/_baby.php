<li class="b-family_li">
    <?php if ($baby->type == Baby::TYPE_PLANNING): ?>
        <div class="b-family_img-hold">
            <div class="ico-family ico-family__baby-plan"></div>
        </div>
        <div class="b-family_tx">
            <span>Планируем</span> <br>
            <span>ребенка</span>
        </div>
    <?php elseif ($baby->type == Baby::TYPE_WAIT): ?>
        <?php
            switch ($baby->sex) {
                case 2:
                    $class = 'baby';
                    $label = 'ребенка';
                    break;
                case 1:
                    $class = 'boy';
                    $label = 'мальчика';
                    break;
                case 0:
                    $class = 'girl';
                    $label = 'девочку';
                    break;
            }
        ?>
        <div class="b-family_img-hold">
            <div class="ico-family ico-family__<?=$class?>-wait"></div>
        </div>
        <div class="b-family_tx">
            <span>Ждем</span> <br>
            <span><?=$label?></span> <br>
            <?php if ($baby->birthday !== null): ?>
                <span><?=$baby->pregnancyWeeks?> неделя</span>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <?php if ($baby->randomPhoto !== null): ?>
            <div class="b-family_img-hold"><?=CHtml::image($baby->randomPhoto->photo->getPreviewUrl(53, 53), $baby->name)?></div>
        <?php elseif ($baby->sex != 2 && $baby->birthday !== null): ?>
            <?php
                if ($baby->fullYears < 1)
                        $subClass = 'small';
                elseif ($baby->fullYears < 3)
                    $subClass = '3';
                elseif ($baby->fullYears < 6)
                    $subClass = '5';
                elseif ($baby->fullYears < 12)
                    $subClass = '8';
                elseif ($baby->fullYears < 18)
                    $subClass = '14';
                else
                    $subClass = '19';

                    $class = (($baby->sex == 1) ? 'boy' : 'girl') . '-' . $subClass;
            ?>
            <div class="b-family_img-hold">
                <div class="ico-family ico-family__<?=$class?>"></div>
            </div>
        <?php else: ?>
            <div class="b-family_img-hold"></div>
        <?php endif; ?>

    <div class="b-family_tx">
        <?php if ($baby->sex != 2): ?>
            <span><?=($baby->sex == 1) ? 'Сын' : 'Дочь'?></span> <br />
        <?php endif; ?>
        <?php if ( !empty($baby->name)): ?>
            <span><?=$baby->name?></span> <br />
        <?php endif; ?>
        <?php if ($baby->birthday !== null): ?>
            <span><?=$baby->textAge?></span>
        <?php endif; ?>
    </div>

    <?php endif; ?>
</li>