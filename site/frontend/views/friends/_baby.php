<li>
    <?php if ($baby->type == Baby::TYPE_PLANNING): ?>
        <div class="img baby-plan"></div>
        <span class="yellow">Планируем</span> <br>
        <span>ребенка</span>
    <?php elseif ($baby->type == Baby::TYPE_WAIT): ?>
        <?php
            switch ($baby->sex) {
                case 2:
                    $class = 'baby';
                    $label = 'ребенка';
                    break;
                case 1:
                    $class = 'boy-wait';
                    $label = 'мальчика';
                    break;
                case 0:
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
        <div class="img">
            <?php if ($baby->randomPhoto !== null): ?>
                <?=CHtml::image($baby->randomPhoto->photo->getPreviewUrl(53, 53), $baby->name)?>
            <?php elseif ($baby->sex != 2 && $baby->birthday !== null): ?>
        </div>
            <?php
                if ($baby->type == Baby::TYPE_PLANNING)
                    $class = 'baby-plan';
                else{
                    if ($baby->type == Baby::TYPE_WAIT)
                        $subClass = 'wait';
                    elseif ($baby->fullYears < 1)
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
                }
            ?>
            <div class="img <?=$class?>"></div>
        <?php endif; ?>
        <?php if ($baby->sex != 2): ?>
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