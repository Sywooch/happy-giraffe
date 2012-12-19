<?php
/* @var $comment_model Comment
 * @var $form CActiveForm
 */
?>
<div id="add_comment" class="comment-add clearfix">

<?php if (Yii::app()->user->isGuest): ?>

   <div class="comment-add_user">
        <a href="javascript:;" onclick="showLoginWindow()">Авторизируйтесь</a>
        <div class="social-small-row clearfix">
            <em>или войти с помощью</em> <br>
            <ul class="social-list-small">
                <?php Yii::app()->eauth->renderWidget(array('action' => 'signup/index', 'mode'=>'small')); ?>
            </ul>
        </div>
    </div>
    <div class="comment-add_form-holder">

        <input type="text" name="" class="input-text" placeholder="Введите ваш комментарий" onclick="showLoginWindow()">

    </div>

<?php else: ?>
<?php
    $user = Yii::app()->user->getModel();
    if ($user->gender !== null) $class = 'ava ' . (($user->gender) ? 'male' : 'female');
    $link_to_profile = ($user->deleted == 1) ? 'javascript:;' : $user->url;
?>
    <div class="comment-add_user">
        <div class="comment-add_user-ava">
            <?= HHtml::link($user->getAva() ? CHtml::image($user->getAva()) : '', $link_to_profile, array('class' => $class)) ?>
            <span style="display: none;" class="comment-add_username"><?=$user->first_name ?><br><?=$user->last_name ?></span>
        </div>
    </div>
    <div class="comment-add_form-holder">

        <input id="dummy-comment" type="text" class="input-text" placeholder="Введите ваш комментарий" onclick="<?= $this->objectName?>.newComment(this);">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'add_comment',
            'htmlOptions' => array(
                'onsubmit' => "".$this->objectName.".send(this, event); return false;",
                'style'=>'display:none;'
            )
        )); ?>

        <div class="quote">
            <input type="hidden" id="Comment_response_id" name="Comment[response_id]" value="" />
            <input type="hidden" id="Comment_quote_id" name="Comment[quote_id]" value="" />
            <input type="hidden" id="Comment_selectable_quote" name="Comment[selectable_quote]" value="" />
        </div>
        <?= $form->hiddenField($comment_model, 'entity', array('value' => $this->entity)); ?>
        <?= $form->hiddenField($comment_model, 'entity_id', array('value' => $this->entity_id)); ?>
        <?= CHtml::hiddenField('edit-id', ''); ?>
        <?= $form->textArea($comment_model, 'text'); ?>
        <div class="a-right">
            <button class="btn-gray medium cancel" onclick="return <?= $this->objectName; ?>.cancel(event);">Отмена</button>
            <button class="btn-green medium">Добавить</button>
        </div>

        <?php $this->endWidget(); ?>

    </div>
    <div style="display: none;">
        <div class="upload-btn" id="refresh_upload">
            <?php
            $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                'model' => new Comment(),
            ));
            $fileAttach->button();
            $this->endWidget();
            ?>
        </div>
    </div>

<?php endif; ?>

</div>
