<?php
$cs = Yii::app()->clientScript;
$js = "
$('button.cancel').live('click', function(e) {
    Comment.clearResponse();
    Comment.clearQuote();
    Comment.selected_text = null;
	e.preventDefault();
	var editor = CKEDITOR.instances['Comment[text]'];
	$('#add_comment .button_panel .btn-green-medium span span').text('Добавить');
    editor.setData('');
    edit_comment = null;
    endEdit();
});
$('#add_comment').live('submit', function(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		data: $(this).serialize(),
		dataType: 'json',
		url: " . CJSON::encode(Yii::app()->createUrl('ajax/sendcomment')) . ",
		success: function(response) {
			if (response.status == 'ok')
			{
			    var pager = $('#comment_list .yiiPager .page:last');
			    var url = false;
			    if(pager.size() > 0 && $('#add_comment .button_panel .btn-green-medium span span').text() != 'Редактировать')
			        url = pager.children('a').attr('href');
			    if(url !== false)
			        $.fn.yiiListView.update('comment_list', {url : url, data : {lastPage : true}});
			    else if($('#add_comment .button_panel .btn-green-medium span span').text() == 'Редактировать')
			        $.fn.yiiListView.update('comment_list');
                else
                    $.fn.yiiListView.update('comment_list', {data : {lastPage : true}});
				var editor = CKEDITOR.instances['Comment[text]'];
                editor.setData('');
                Comment.clearResponse();
                Comment.clearQuote();
                Comment.selected_text = null;
                $('#add_comment .button_panel .btn-green-medium span span').text('Добавить');
			}
		},
	});
});


$('body').delegate('a.edit-comment', 'click', function () {
    Comment.clearResponse();
    Comment.clearQuote();
    Comment.selected_text = null;
    var id = $(this).parents('.item').attr('id').replace(/comment_/g, '');
    $('#edit-id').val(id);
    var editor = CKEDITOR.instances['Comment[text]'];

    if($(this).parents('.item').find('.quote').size() > 0)
    {
        var html = '';
        html += '<div class=\"quote\">'+$(this).parents('.item').find('.quote').html()+'</div>';
        html += $(this).parents('.item').find('.content-in').html();
        editor.setData(html);
        $('#add_comment').find('.quote #Comment_quote_id').val($(this).parents('.item').find('.quote').attr('id').split('_')[1]);
        $('#add_comment').find('.quote #Comment_selectable_quote').val($(this).parents('.item').find('input[name=selectable_quote]').val());
    }
    else
        editor.setData($(this).parents('.item').find('.content-in').html());
    $('#add_comment .button_panel .btn-green-medium span span').text('Редактировать');

    $('html,body').animate({scrollTop: $('#add_comment').offset().top - 100},'fast');
    return false;
});

function endEdit(){
    $('#add_comment .button_panel .btn-green-medium span span').text('Добавить');
    $('#edit-id').val('');
}";
$cs->registerScript('comment_widget_form', $js);
?>
<?php $this->render('list', array('dataProvider' => $dataProvider)); ?>

<?php if (!Yii::app()->user->isGuest): ?>
<div class="new_comment">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'add_comment',
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
        <button class="btn btn-gray-medium cancel"><span><span>Отмена</span></span></button>
        <button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php endif; ?>