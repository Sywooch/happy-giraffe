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
            <a href="" class="like-control_ico like-control_ico__repost js-hg_alert" data-bind="text: count"></a>
            <div class="favorites-add-popup favorites-add-popup__right" style="display: none;">
                <div>Нельзя сделать репост своей записи</div>
            </div>
        <?php else: ?>
            <a href="" class="like-control_ico like-control_ico__repost powertip" data-bind="text: count, css: { active : active }, tooltip: active() ? 'Удалить репост' : 'Репост', click: clickHandler"></a>
        <?php endif ?>

        <?php $this->render('repost_popup'); ?>
    </div>

    <?php if ($this->applyBindings):?>
    <script type="text/javascript">
        ko.applyBindings(new RepostWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$id.$t?>'));
    </script>
    <?php endif ?>

<?php else: ?>

    <div<?php if (!$this->right) echo ' class="favorites-control"'; else echo ' class="position-rel"'; ?>>
        <a href="#loginWidget" class="like-control_ico like-control_ico__repost popup-a" title="Репост">
            <?=$count?>
        </a>
    </div>

<?php endif; ?>