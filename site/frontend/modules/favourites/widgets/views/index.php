<?php
/**
 * @var string $id
 * @var $data
 */
?>

<div class="favorites-control" id="<?=$id?>">
    <a href="javascript:void(0)" class="favorites-control_a powertip" data-bind="text: count, css: { active : active }, tooltip: active() ? 'Удалить из избранного' : 'В избранное', click: clickHandler">

    </a>

    <?php $this->render('_popup'); ?>
</div>

<script type="text/javascript">
    ko.applyBindings(new FavouriteWidget(<?=CJSON::encode($data)?>), document.getElementById('<?=$id?>'));
</script>