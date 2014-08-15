<?php
/**
 * @var CommunitySection $section
 * @var string $class
 */
?>

<div class="site-map_section">
    <div class="site-map_i"><a href="<?=$section->getUrl()?>" class="site-map_a site-map_a__<?=$class?>"><?=$section->title?></a></div>
    <ul class="menu-simple">
        <?php foreach ($section->clubs as $club): ?>
            <li class="menu-simple_li"><a href="<?=$club->getUrl()?>" class="a-light fontweight-b"><?=$club->title?></a></li>
            <?php foreach ($club->communities as $community): ?>
                <li class="menu-simple_li"><a href="<?=$community->getUrl()?>" class="a-light"><?=$community->title?></a></li>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </ul>
</div>