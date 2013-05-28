<?php
/**
 * @var string $id
 * @var $data
 */
?>

<div class="cook-book-info" id="<?=$id?>">
    <a href="javascript:void(0)" data-bind="click: clickHandler">
        <span data-bind="html: active() ? 'Рецепт в моей <br />кулинарной книге' : 'Добавить в мою <br />кулинарную книгу'"></span>
        <i data-bind="css: active() ? 'icon-exist' : 'icon-add'"></i>
    </a>

    <?php $this->render('_popup'); ?>
</div>

<script type="text/javascript">
    ko.applyBindings(new FavouriteWidget(<?=CJSON::encode($data)?>), document.getElementById('<?=$id?>'));
</script>