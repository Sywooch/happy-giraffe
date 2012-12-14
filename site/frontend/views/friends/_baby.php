<li>
    <?php if ($baby->type = Baby::TYPE_PLANNING): ?>
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
        <span class="pink-text"><?=$baby->prenancyPeriod?> неделя</span>
    <?php else: ?>
        <?php if ($baby->sex != 0): ?>
            <span class="yellow"><?=($baby->sex == 1) ? 'Сын' : 'Дочь'?></span> <br />
        <?php endif; ?>
        <?php if ($baby->name): ?>
            <span><?=$baby->name?></span> <br />
        <?php endif; ?>
        <span class="yellow">3 мес.</span>
    <?php endif; ?>
</li>