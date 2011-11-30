<?php
/**
 * @var $placentaThickness PlacentaThickness
 * @var $model PlacentaThicknessForm
 * Author: alexk984
 * Date: 30.11.11
 * Time: 12:54
 */
 
echo $placentaThickness->min.' < '.$placentaThickness->avg.' < '.$placentaThickness->max;
echo '<br>';
if ($model->thickness < $placentaThickness->min)
    echo 'слишком тонкая';
elseif ($model->thickness < $placentaThickness->avg)
    echo 'нормальная толщина';
else
    echo 'слишком толстая';