<div class="photo-window_right">

    <div class="photo-window_banner-hold clearfix">
        <img src="/images/example/w300-h250.jpg" alt="">
    </div>

    <?php $this->render('view', array('comments' => $comments)); ?>

</div>

<div class="photo-window_right-bottom <?=$this->objectName ?>">
    <div class="comments-gray comments-gray__photo-add">
        <div class="comments-gray_add clearfix">

            <?php if (!Yii::app()->user->isGuest):?>
                <div class="comments-gray_ava">
                    <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 24)) ?>
                </div>
            <?php endif ?>
            <div class="comments-gray_frame">
                <input type="text" id="add_<?=$this->objectName ?>" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий" data-bind="enterKey: addComment" value="">
            </div>
        </div>
    </div>
</div>