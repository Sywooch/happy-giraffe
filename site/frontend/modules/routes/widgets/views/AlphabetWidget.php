<?php
/**
 * @var string[] $letters
 */
?>

<ul class="map-route-abc_ul">
    <?php foreach ($letters as $l): ?>
        <li class="map-route-abc_li"><a href="<?=Yii::app()->createUrl('/routes/default/cities', array('letter' => $l))?>" class="map-route-abc_a"><?=$l?></a></li>
    <?php endforeach; ?>
</ul>