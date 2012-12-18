<li>
    <?php if ($baby->type == Baby::TYPE_PLANNING): ?>
        <div class="img baby-plan"></div>
        <span class="yellow">Планируем</span> <br>
        <span>ребенка</span>
    <?php elseif ($baby->type == Baby::TYPE_WAIT): ?>
        <?php
            switch ($baby->sex) {
                case 0:
                    $class = 'baby';
                    $label = 'ребенка';
                    break;
                case 1:
                    $class = 'boy-wait';
                    $label = 'мальчика';
                    break;
                case 2:
                    $class = 'girl-wait';
                    $label = 'девочку';
                    break;
            }
        ?>
        <div class="img <?=$class?>"></div>
        <span>Ждем</span> <br>
        <span class="yellow"><?=$label?></span> <br>
        <?php if ($baby->birthday !== null): ?>
            <span class="pink-text"><?=$baby->pregnancyWeeks?> неделя</span>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($baby->randomPhoto !== null): ?>
            <div class="img"><?=CHtml::image($baby->randomPhoto->photo->getPreviewUrl(66, 66), $baby->name)?></div>
        <?php elseif ($baby->sex != 0 && $baby->birthday): ?>
            <?php
                if ($baby->fullYears < 1)
                    $subClass = 'small';
                elseif ($baby->fullYears < 3)
                    $subClass = '3';
                elseif ($baby->fullYears < 6)
                    $subClass = '5';
                elseif ($baby->fullYears < 12)
                    $subClass = '8';
                elseif ($baby->fullYears < 15)
                    $subClass = '14';
                else
                    $subClass = '17';

                $class = (($baby->sex == 1) ? 'boy' : 'girl') . '-' . $subClass;
            ?>
            <div class="img <?=$class?>"></div>
        <?php endif; ?>
        <?php if ($baby->sex != 0): ?>
            <span class="yellow"><?=($baby->sex == 1) ? 'Сын' : 'Дочь'?></span> <br />
        <?php endif; ?>
        <?php if ( !empty($baby->name)): ?>
            <span><?=$baby->name?></span> <br />
        <?php endif; ?>
        <?php if ($baby->birthday !== null): ?>
            <span class="yellow"><?=$baby->textAge?></span>
        <?php endif; ?>
    <?php endif; ?>
</li>