<?php if (Yii::app()->user->isGuest):?>
    <a href="#loginWidget" class="like-control_ico like-control_ico__like powertip popup-a" title="Нравится"><?=$count ?></a>
<?php else: ?>
    <?php if ($this->model->author_id == Yii::app()->user->id):?>
        <a href="" class="like-control_ico like-control_ico__like js-hg_alert"><?=$count ?></a>
        <div class="favorites-add-popup favorites-add-popup__right" style="display: none;">
            <div>Вы не можете нажать кнопку "Нравится" в своей записи</div>
        </div>
    <?php else: ?>
        <a href="" class="like-control_ico like-control_ico__like powertip<?php if ($active) echo ' active' ?>"
           onclick="HgLike(this, '<?=$this->class ?>',<?=$this->model->id ?>);return false;" title="Нравится"><?=$count ?></a>
    <?php endif ?>
<?php endif ?>