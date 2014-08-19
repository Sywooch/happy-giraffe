<ul class="map-route-abc_ul">
    <?php foreach (RangeHelper::alphabet() as $l): ?>
        <li class="map-route-abc_li"><a href="<?=$this->createUrl('cities', array('letter' => $l))?>" class="map-route-abc_a"><?=$l?></a></li>
    <?php endforeach; ?>
</ul>