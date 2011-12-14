<?php
/**
 * @var $placentaThickness PlacentaThickness
 * @var $model PlacentaThicknessForm
 * Author: alexk984
 * Date: 30.11.11
 * Time: 12:54
 */

//$placentaThickness->min = str_replace('.', ',', $placentaThickness->min);
//$placentaThickness->max = str_replace('.', ',', $placentaThickness->max);
//$placentaThickness->avg = str_replace('.', ',', $placentaThickness->avg);
//$model->thickness = str_replace('.', ',', $model->thickness);
if ($model->thickness < $placentaThickness->min) {
    ?>
<div class="placenta_recomendation">
    <span class="title_p">Ниже нормы</span>
    <div class="seo-text">

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
    <p>Подобное истончение требует врачебной консультации и принятия мер, так как угрожает прерыванием беременности и
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
}
elseif ($model->thickness <= $placentaThickness->max)
{
    ?>
<div class="placenta_recomendation">
    <span class="title_p">Норма</span>

    <div class="seo-text">
    <p>Для этого нужно ввести срок беременности и толщину плаценты (данные можно посмотреть в описании последнего УЗИ) и
        нажать кнопку «Определить». Через секунду вы получите результат и узнаете, соответствует ли ваша плацента норме,
        а также прочитаете рекомендации по дальнейшим действиям. Удачи!</p>
    </div>
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
    ?>
<div class="placenta_recomendation">
    <span class="title_p">Выше нормы</span>

    <div class="seo-text">
    <p>Толщина вашей плаценты выше нормы. Это может быть вызвано:</p>
    <ul>
        <li>индивидуальной особенностью плаценты (её форма – в виде шара),</li>
        <li>неправильно произведенным измерением плаценты.</li>
    </ul>
    <p>Если же имеются признаки фетоплацентарной недостаточности, то утолщение плаценты может быть обусловлено:</p>
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
}