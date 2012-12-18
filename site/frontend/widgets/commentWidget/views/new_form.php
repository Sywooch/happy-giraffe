<?php
/* @var $comment_model Comment
 * @var $form CActiveForm
 */
?><?php if (Yii::app()->user->isGuest): ?>

<div class="comment-add clearfix">
    <div class="comment-add_user">
        <a href="#login" class="fancy">Авторизируйтесь</a>
        <div class="social-small-row clearfix">
            <em>или войти с помощью</em> <br>
            <ul class="social-list-small">
                <li><a href="#" class="odnoklasniki"></a></li>
                <li><a href="#" class="mailru"></a></li>
                <li><a href="#" class="vk"></a></li>
                <li><a href="#" class="fb"></a></li>
            </ul>
        </div>
    </div>
    <div class="comment-add_form-holder">
        <input type="text" name="" class="input-text" placeholder="Введите ваш комментарий" onclick="showComment(this)">

            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'add_comment',
                'htmlOptions' => array(
                    'onsubmit' => "return ".$this->objectName.".send(this, event);",
                    'style'=>'display:none;'
                )
            )); ?>

            <input type="hidden" id="Comment_response_id" name="Comment[response_id]" value="" />
            <input type="hidden" id="Comment_quote_id" name="Comment[quote_id]" value="" />
            <input type="hidden" id="Comment_selectable_quote" name="Comment[selectable_quote]" value="" />
            <?= $form->hiddenField($comment_model, 'entity', array('value' => $this->entity)); ?>
            <?= $form->hiddenField($comment_model, 'entity_id', array('value' => $this->entity_id)); ?>
            <?= CHtml::hiddenField('edit-id', ''); ?>
            <?php $this->widget('ext.ckeditor.CKEditorWidget', array(
                'model' => $comment_model,
                'attribute' => 'text',
                'config' => array(
                    'width' => 506,
                    'height' => 56,
                    'toolbar' => 'Chat',
                    'skin'=>'hgrucomment'
                ),
            )); ?>
            <div class="a-right">
                <button class="btn-gray medium cancel" onclick="return <?= $this->objectName; ?>.cancel(event);">Отмена</button>
                <button class="btn-green medium">Добавить</button>
            </div>

        <?php $this->endWidget(); ?>

    </div>
</div>

<?php else: ?>

<div class="comment-add active clearfix">
    <div class="comment-add_user">
        <div class="comment-add_user-ava">
            <a href="" class="ava female"><img alt="" src="http://img.happy-giraffe.ru/avatars/13623/ava/7acd577045e2014b4d26ecd33f6ce6d2.jpeg"></a>
            <span class="comment-add_username">Татьяна Пахоменко </span>
        </div>
    </div>
    <div class="comment-add_form-holder">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'add_comment',
            'htmlOptions' => array('onsubmit' => "return ".$this->objectName.".send(this, event);")
        )); ?>

        <input type="hidden" id="Comment_response_id" name="Comment[response_id]" value="" />
        <input type="hidden" id="Comment_quote_id" name="Comment[quote_id]" value="" />
        <input type="hidden" id="Comment_selectable_quote" name="Comment[selectable_quote]" value="" />
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
</div>
<?php endif; ?>

<?php $this->render('list', array('dataProvider' => $dataProvider,'type'=>$type)); ?>
<script type="text/javascript">
    var cke_instance = '<?= $this->commentModel; ?>_text';
</script>
