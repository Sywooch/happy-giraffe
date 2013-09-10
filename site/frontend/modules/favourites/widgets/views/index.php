<?php
/**
 * @var string $id
 * @var $json
 * @var int $count
 */
$t = substr((string)microtime(true), -4);
?>
<?php if (! Yii::app()->user->isGuest): ?>

    <div<?php if (!$this->right) echo ' class="favorites-control"'; else echo ' class="position-rel"'; ?> id="<?=$id.$t?>">
        <?php if ($this->model->author_id == Yii::app()->user->id):?>
            <a href="" class="favorites-control_a js-hg_alert" data-bind="text: count"></a>
            <div class="favorites-add-popup favorites-add-popup__right" style="display: none;">
                <div>Вы не можете добавлять свою запись в Избранное</div>
            </div>
        <?php else: ?>
            <a href="" class="favorites-control_a powertip" data-bind="text: count, css: { active : active }, tooltip: active() ? 'Удалить из избранного' : 'В избранное', click: clickHandler"></a>
            <?php $this->render('_popup'); ?>
        <?php endif ?>
    </div>

<?php if ($this->applyBindings):?>
        <script type="text/javascript">
            ko.applyBindings(new FavouriteWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$id.$t?>'));
        </script>
<?php endif ?>

<?php else: ?>

    <div<?php if (!$this->right) echo ' class="favorites-control"'; else echo ' class="position-rel"'; ?>>
        <a href="#login" class="favorites-control_a powertip fancy" title="В избранное">
            <?=$count?>
        </a>
    </div>

<?php endif; ?>