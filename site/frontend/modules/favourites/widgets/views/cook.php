<?php
/**
 * @var string $id
 * @var $json
 * @var int $count
 */
?>

<?php if (! Yii::app()->user->isGuest): ?>

    <div<?php if (!$this->right) echo ' class="favorites-control"'; else echo ' class="position-rel"'; ?> id="<?=$id?>">
        <?php if ($this->model->author_id == Yii::app()->user->id):?>
            <a class="like-control_ico like-control_ico__cook js-hg_alert" data-bind="text: count"></a>
            <div class="favorites-add-popup favorites-add-popup__right" style="display: none;">
                <div>Вы не можете добавлять свою запись в Избранное</div>
            </div>
        <?php else: ?>
            <a class="like-control_ico like-control_ico__cook" data-bind="text: count, css: { active : active }, tooltip: active() ? 'Удалить из избранного' : 'В избранное', click: clickHandler"></a>
            <?php $this->render('_popup'); ?>
        <?php endif ?>
    </div>

    <?php if ($this->applyBindings):?>
        <script type="text/javascript">
            ko.applyBindings(new FavouriteWidget(<?=CJSON::encode($json)?>), document.getElementById('<?=$id?>'));
        </script>
    <?php endif ?>

<?php else: ?>

    <a href="#login" class="like-control_ico like-control_ico__cook"><?=$count?></a>

<?php endif; ?>