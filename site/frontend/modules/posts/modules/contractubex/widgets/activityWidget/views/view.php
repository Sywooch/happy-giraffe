<div class="club-promo-onair">
    <div class="club-promo-onair_arrows clearfix">
        <?php if ($dp->pagination->currentPage == 0): ?>
            <span class="club-promo-onair_arrows_arrow club-promo-onair_arrows_left inactive"></span>
        <?php else: ?>
            <a onclick="moveTo('<?=$this->controller->createUrl('', array('page' => ($dp->pagination->currentPage)))?>');" class="club-promo-onair_arrows_arrow club-promo-onair_arrows_left"></a>
        <?php endif; ?>
        <?php if ($dp->pagination->pageCount <= ($dp->pagination->currentPage + 1)): ?>
            <span class="club-promo-onair_arrows_arrow club-promo-onair_arrows_right inactive"></span>
        <?php else: ?>
            <a onclick="moveTo('<?=$this->controller->createUrl('', array('page' => ($dp->pagination->currentPage + 2)))?>');" class="club-promo-onair_arrows_arrow club-promo-onair_arrows_right"></a>
        <?php endif; ?>
    </div>

    <?php
    $this->widget('\LiteListView', array(
        'htmlOptions' => array(
            'class' => 'club-promo-onair_items',
        ),
        'dataProvider' => $dp,
        'itemView' => '_post',
        'template' => '{items}',
    ));
    ?>
</div>

<script>
function addBadges() {
    var uids = [436814,436904,436969,15426,20010,24976,190451,55714,453538,193744,453543,453548,228562,453568,453588,453593,246395,258700,25524,16208,197095,19982,113864,443509,181638,15814,181065,453743,453748,453778,453783,453793,453808,453813,453823,10374,453858,453868,453888,453918,453898,453948,453943,453968,453973,453978,454107,454172,454187,454192,454207,454242,454257,454262,454272,454252,454282,454292,454302,453468,453398,448954,453443,10419,454357,454312,454407,454412,454447,454452,454467,454472,454482,454507,454487,435844,435994,436034,436084,436174,436219,436239,436339,436484];

    $('.club-promo-onair_items_item').each(function(index, element) {
        var id = parseInt($(element).find('.ava').attr('href').replace ( /[^\d]/g, '' ));
        console.log(id);
        console.log(uids.indexOf(id));
        if (uids.indexOf(id) != -1) {
            $(element).find('.club-promo-onair_items_item_top').prepend('<div class="promo-like-badge"><div class="promo-like-badge_img"></div></div>');
        }
    });
}


function moveTo(url) {
    $.get(url, function(html) {
        $('.club-promo-onair').replaceWith($(html).find('.club-promo-onair'));
        addBadges();
        require(['knockout', 'ko_library'], function(ko) {
            ko.applyBindings({}, $('.club-promo-onair time').get(0));
        });
    });
}

$(function() {
    addBadges();
});
</script>