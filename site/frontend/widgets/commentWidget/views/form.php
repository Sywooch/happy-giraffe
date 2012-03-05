<?php
$cs = Yii::app()->clientScript;
$js = "Comment.save_url = " . CJavaScript::encode(Yii::app()->createUrl('ajax/sendcomment'));
$cs->registerScript('comment_widget_form', $js);
?>
<?php $this->render('list', array('dataProvider' => $dataProvider)); ?>

<?php if (!Yii::app()->user->isGuest): ?>
<div class="new_comment" id="new_comment_wrapper">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'add_comment',
    'htmlOptions' => array(
        'onsubmit' => "return Comment.send(this, event);",
    ),
)); ?>
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
    <?php
    $this->widget('ext.ckeditor.CKEditorWidget', array(
        'model' => $comment_model,
        'attribute' => 'text',
        'config' => array(
            'toolbar' => 'Nocut',
            'protectedSource' => '<blockquote>'
        ),
    ));
    ?>
    <div class="button_panel">
        <button class="btn btn-gray-medium cancel" onclick="return Comment.cancel(event);"><span><span>Отмена</span></span></button>
        <button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php endif; ?>