<?php
/**
 * @var $placentaThickness PlacentaThickness
 * @var $model PlacentaThicknessForm
 * Author: alexk984
 * Date: 30.11.11
 * Time: 12:54
 */

//echo $placentaThickness->min . ' < ' . $placentaThickness->avg . ' < ' . $placentaThickness->max;
$placentaThickness->min = str_replace('.', ',', $placentaThickness->min);
$placentaThickness->max = str_replace('.', ',', $placentaThickness->max);
$placentaThickness->avg = str_replace('.', ',', $placentaThickness->avg);
$model->thickness = str_replace('.', ',', $model->thickness);
if ($model->thickness < $placentaThickness->min) {
    ?>
<div class="placenta_recomendation">
    <span class="title_p">Рекомендации:</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные
        железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности
        происходил </p>
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
    <span class="title_p">Рекомендации:</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные
        железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности
        происходил </p>
    <ul class="placent_norm">
        <li class="your_w"><?php echo $model->thickness ?>
            <ins>мм</ins>
        </li>
        <li class="your_pr">Толщина
            в
            норме
        </li>
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
    <span class="title_p">Рекомендации:</span>

    <p>Одним из основных свидетельств правильного течения беременности является набор веса согласно принятым нормам.
        Оптимальный набор веса при беременности — это 10–14 кг. Набираемый вес при беременности складывается из
        нескольких показателей: вес ребенка, матки, околоплодных вод, плаценты, а также увеличиваются молочные
        железы,
        объем циркулирующей крови, ну и, конечно, появляется запас жировой ткани. Желательно, чтобы набор веса при
        беременности происходил постепенно, без рывков.ткани. Желательно, чтобы набор веса при беременности
        происходил </p>
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