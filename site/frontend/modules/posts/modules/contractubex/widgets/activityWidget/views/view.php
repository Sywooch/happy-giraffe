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
function moveTo(url) {
    $.get(url, function(html) {
        $('.club-promo-onair').replaceWith($(html).find('.club-promo-onair'));
        require(['knockout', 'ko_library'], function(ko) {
            ko.applyBindings({}, $('.club-promo-onair time').get(0));
        });
    });
}
</script>