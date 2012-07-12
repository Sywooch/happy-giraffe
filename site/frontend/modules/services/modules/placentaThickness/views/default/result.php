<?php
/**
 * @var $placentaThickness PlacentaThickness
 * @var $model PlacentaThicknessForm
 */

$model->thickness = str_replace(',', '.', $model->thickness);

if ($model->thickness < $placentaThickness->min) {
    if (($model->week >= 20 && $model->thickness >= 15) ||
        ($model->week < 20 && $model->thickness >= $placentaThickness->min * 0.8)
    ) {
        ?>
    <div class="placenta_recomendation">
        <span class="title_p">Ниже нормы</span>

        <div class="wysiwyg-content">

            <p>Толщина вашей плаценты ниже нормы. Это может быть вызвано:</p>
            <ul>
                <li>индивидуальной особенностью плаценты (её форма – в виде тонкой лепёшки),</li>
                <li>неправильно произведенным измерением плаценты.</li>
            </ul>
            <p>Если имеет место фетоплацентарная недостаточность, то истончение плаценты может быть вызвано:</p>
            <ul>
                <li>поздним токсикозом,</li>
                <li>преэклампсией,</li>
                <li>сахарным диабетом 1 типа у матери,</li>
                <li>пороком развития плодного места.</li>
            </ul>
            <p>Подобное истончение требует врачебной консультации и принятия мер, так как угрожает прерыванием
                беременности и
                может способствовать задержке развития плода.</p>
        </div>
        <ul class="placent_norm">
            <li class="your_w"><?php echo $model->thickness ?>
                <ins>мм</ins>
            </li>
            <li class="your_pr">Толщина
                <ins><</ins>
                нормы
            </li>
            <li class="your_wn"><span><?php echo $placentaThickness->min ?> - <?php echo $placentaThickness->max ?>
                <ins>мм</ins></span></li>
        </ul>
    </div>
    <!-- .placenta_recomendation -->
    <?php
    } else {
        ?>
    <div class="placenta_recomendation">
        <span class="title_p">Значительно ниже нормы</span>

        <p>Полученный результат значительно ниже нормы. Обычно так не бывает. Проверьте – правильно ли вы ввели
            данные. Срок беременности нужно вводить именно тот, на котором было проведено УЗИ. Если результат
            сохраняется – возможно, была неправильно измерена толщина плаценты на УЗИ. Обратитесь с вопросом к
            своему гинекологу.</p><br><br>
        <ul class="placent_norm">
            <li class="your_w"><?php echo $model->thickness ?>
                <ins>мм</ins>
            </li>
            <li class="your_pr">Толщина
                <ins><</ins>
                нормы
            </li>
            <li class="your_wn"><span><?php echo $placentaThickness->min ?> - <?php echo $placentaThickness->max ?>
                <ins>мм</ins></span></li>
        </ul>
    </div>
    <!-- .placenta_recomendation -->
    <?php
    }
} elseif ($model->thickness <= $placentaThickness->max) {
    ?>
<div class="placenta_recomendation">
    <span class="title_p">Норма</span>

    <p>Поздравляем! Толщина вашей плаценты соответствует норме. Ваш малыш получает все необходимые питательные
        вещества, кислород и иммунную защиту. Это способствует его нормальному развитию. Не забывайте, что плацента
        не является барьером для вирусов, никотина и алкогольных напитков. Старайтесь дышать свежим воздухом,
        избегать спиртосодержащих продуктов и не болеть вирусными заболеваниями.</p>
    <ul class="placent_norm">
        <li class="your_w"><?php echo $model->thickness ?>
            <ins>мм</ins>
        </li>
        <li class="your_pr">Толщина в норме</li>
        <li class="your_wn"><span><?php echo $placentaThickness->min ?> - <?php echo $placentaThickness->max ?>
            <ins>мм</ins></span></li>
    </ul>
</div>
<!-- .placenta_recomendation -->
<?php
}
else {
    if ($model->thickness <= $placentaThickness->max * 1.2) {
        ?>
    <div class="placenta_recomendation">
        <span class="title_p">Выше нормы</span>

        <div class="wysiwyg-content">
            <p>Толщина вашей плаценты выше нормы. Это может быть вызвано:</p>
            <ul>
                <li>индивидуальной особенностью плаценты (её форма – в виде шара),</li>
                <li>неправильно произведенным измерением плаценты.</li>
            </ul>
            <p>Если же имеются признаки фетоплацентарной недостаточности, то утолщение плаценты может быть
                обусловлено:</p>
            <ul>
                <li>резус-конфликтом,</li>
                <li>острым инфекционным процессом,</li>
                <li>сифилисом,</li>
                <li>пороком развития плаценты,</li>
                <li>сахарным диабетом 2 типа,</li>
                <li>гипертонической болезнью у матери.</li>
            </ul>
            <p>Эти случаи требуют консультации врача и назначения соответствующего лечения.</p>
        </div>

        <ul class="placent_norm">
            <li class="your_w"><?php echo $model->thickness ?>
                <ins>мм</ins>
            </li>
            <li class="your_pr">Толщина
                <ins>></ins>
                нормы
            </li>
            <li class="your_wn"><span><?php echo $placentaThickness->min ?> - <?php echo $placentaThickness->max ?>
                <ins>мм</ins></span></li>
        </ul>
    </div>
    <!-- .placenta_recomendation -->
    <?php
    } else {
        ?>
    <div class="placenta_recomendation">
        <span class="title_p">Значительно выше нормы</span>

        <div class="wysiwyg-content">
            <p>Полученный результат значительно выше нормы. Обычно так не бывает. Проверьте, правильно ли вы ввели
                данные. Срок беременности нужно вводить именно тот, на котором было проведено УЗИ. Если результат
                сохраняется – возможно, была неправильно измерена толщина плаценты на УЗИ. Обратитесь с вопросом к
                своему гинекологу.</p><br>
        </div>

        <ul class="placent_norm">
            <li class="your_w"><?php echo $model->thickness ?>
                <ins>мм</ins>
            </li>
            <li class="your_pr">Толщина
                <ins>></ins>
                нормы
            </li>
            <li class="your_wn"><span><?php echo $placentaThickness->min ?> - <?php echo $placentaThickness->max ?>
                <ins>мм</ins></span></li>
        </ul>
    </div>
    <!-- .placenta_recomendation -->
    <?php
    }
}
