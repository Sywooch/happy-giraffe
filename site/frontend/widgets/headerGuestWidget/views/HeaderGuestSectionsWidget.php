<?php
/** @var CommunitySection[] $sections */
$sections = CommunitySection::model()->with('clubs')->findAll();

$cs = Yii::app()->clientScript;
$js = '
$(document).mouseup(function (e)
{
    var container = $(".header-forums-list, .header-menu_a");
    var list = $(".header-forums-list");

    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
        list.hide();
    }
});

$(".header-menu_a").on("click", function(e) {
    var next = $(this).next();
    var nextVisible = next.is(":visible");
    console.log(nextVisible);
    $(".header-forums-list:visible").hide();
    if (! nextVisible) {
        next.show();
    }
});
';

if ($cs->useAMD) {
    $cs->registerAMD('headerGuestWidget', array('common'), $js);
} else {
    $cs->registerScript('headerGuestWidget', $js);
}
?>

<div class="header-menu header-menu-guest">
    <ul class="header-menu_ul clearfix">
        <?php foreach ($sections as $section): ?>
            <li class="header-menu_li header-menu-guest_section-<?=$section->id?>">
                <a href="javascript:void(0)" class="header-menu_a">
                    <span class="header-menu_ico"></span>
                    <span class="header-menu_tx"><?=$section->title?></span>
                </a>
                <ul class="header-forums-list">
                    <?php foreach ($section->clubs as $club): ?>
                        <li class="header-forums-list_li"><a href="<?=$club->getUrl()?>" class="header-forum-list_a"><?=$club->title?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>
        <li class="header-menu_li">
            <a href="<?=Yii::app()->createUrl('/search/default/index')?>" class="header-menu_a">
                <span class="header-menu_ico header-menu_ico__search"></span>
                <span class="header-menu_tx">Поиск</span>
            </a>
        </li>
    </ul>
</div>
