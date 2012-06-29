<?php $this->render('list', array('dataProvider' => $dataProvider,'type'=>$type)); ?>

<?php if (!Yii::app()->user->isGuest): ?>
<div class="new_comment new-comment" id="new_comment_wrapper">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'add_comment',
    'htmlOptions' => array(
        'onsubmit' => "return ".$this->objectName.".send(this, event);",
        'style' => 'display:none;',
    ),
)); ?>
    <?php if($this->vote): ?>
        <span>Ваша оценка:</span>
        <div class="rating setRating" onmouseout="setRatingOut(this);">
            <span onmouseover="setRatingHover(this, 1);" onclick="setRating(this,1);"></span>
            <span onmouseover="setRatingHover(this, 2);" onclick="setRating(this,2);"></span>
            <span onmouseover="setRatingHover(this, 3);" onclick="setRating(this,3);"></span>
            <span onmouseover="setRatingHover(this, 4);" onclick="setRating(this,4);"></span>
            <span onmouseover="setRatingHover(this, 5);" onclick="setRating(this,5);"></span>
            <?php echo $form->hiddenField($comment_model, 'rating'); ?>
        </div>
        <br/>
    <?php endif; ?>
    <div class="response">
        <input type="hidden" id="Comment_response_id" name="Comment[response_id]" value="" />
    </div>
    <div class="quote">
        <input type="hidden" id="Comment_quote_id" name="Comment[quote_id]" value="" />
        <input type="hidden" id="Comment_selectable_quote" name="Comment[selectable_quote]" value="" />
    </div>
    <?php echo $form->hiddenField($comment_model, 'entity', array('value' => $this->entity)); ?>
    <?php echo $form->hiddenField($comment_model, 'entity_id', array('value' => $this->entity_id)); ?>
    <?php echo CHtml::hiddenField('edit-id', ''); ?>
    <?php echo $form->textArea($comment_model, 'text'); ?>
    <?php
    /*$this->widget('ext.ckeditor.CKEditorWidget', array(
        'model' => $comment_model,
        'attribute' => 'text',
        'config' => array(
            'toolbar' => 'Nocut',
            'protectedSource' => '<blockquote>'
        ),
    ));*/
    ?>
    <div class="button_panel">
        <button class="btn btn-gray-medium cancel" onclick="return <?php echo $this->objectName; ?>.cancel(event);"><span><span>Отмена</span></span></button>
        <button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
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
<script type="text/javascript">
    var cke_instance = '<?php echo $this->commentModel; ?>_text';
</script>