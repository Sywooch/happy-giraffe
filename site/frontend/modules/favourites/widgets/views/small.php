<?php
/**
 * @var string $id
 * @var $json
 * @var int $count
 */
$t = substr((string)microtime(true), -4);
?>

<?php if (! Yii::app()->user->isGuest): ?>
    <div id="<?=$id.$t.'small'?>">
        <a class="ava-list_last" data-bind="click: clickHandler">
            <span class="ava-list_favorite" data-bind="css: { active : active }"></span>
            <span class="count" data-bind="text: count"></span><span class="andyou" data-bind="visible: active"> и вы</span>
        </a>
        <?php $this->render('_popup'); ?>
    </div>

    <?php if ($this->applyBindings):?>
        <script type="text/javascript">
            ko.applyBindings(new FavouriteWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$id.$t.'small'?>'));
        </script>
    <?php endif ?>
<?php else: ?>
    <a class="ava-list_last powertip fancy" href="#login" title="В избранное">
        <span class="ava-list_favorite"></span>
        <span class="count"><?=$count?></span>
    </a>
<?php endif; ?>