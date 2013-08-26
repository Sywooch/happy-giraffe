<?php
/**
 * @var string $id
 * @var $json
 * @var int $count
 */
?>

<?php if (! Yii::app()->user->isGuest): ?>

    <div<?php if (!$this->right) echo ' class="favorites-control"'; else echo ' class="position-rel"'; ?> id="<?=$id?>">
        <a href="" class="like-control_ico like-control_ico__repost powertip" data-bind="text: count, css: { active : active }, tooltip: active() ? 'Удалить репост' : 'Репост', click: clickHandler">

        </a>

        <?php $this->render('_popup'); ?>
    </div>

<?php if ($this->applyBindings):?>
<script type="text/javascript">
    ko.applyBindings(new RepostWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$id?>'));
</script>
<?php endif ?>

<?php else: ?>

    <div<?php if (!$this->right) echo ' class="favorites-control"'; else echo ' class="position-rel"'; ?>>
        <a href="#login" class="favorites-control_a powertip fancy" title="В избранное">
            <?=$count?>
        </a>
    </div>

<?php endif; ?>