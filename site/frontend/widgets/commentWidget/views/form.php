<?php
$cs = Yii::app()->clientScript;
$js = "
$('button.cancel').live('click', function(e) {
    Comment.clearResponse();
    Comment.clearQuote();
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
			    if(pager.size() > 0)
			        url = pager.children('a').attr('href');
			    if(url !== false)
			        $.fn.yiiListView.update('comment_list', {url : url, data : {lastPage : true}});
                else
                    $.fn.yiiListView.update('comment_list', {data : {lastPage : true}});
				var editor = CKEDITOR.instances['Comment[text]'];
                editor.setData('');
                Comment.clearResponse();
                Comment.clearQuote();
                $('#add_comment .button_panel .btn-green-medium span span').text('Добавить');
			}
		},
	});
});

/*$('body').delegate('a.remove-comment', 'click', function () {
        if (confirm('Вы точно хотите удалить комментарий?')) {
            var id = $(this).parents('.item').attr('id').replace(/comment_/g, '');
            $.ajax({
                url:'" . Yii::app()->createUrl("ajax/deleteComment") . "',
                data:{id:id},
                type:'POST',
                dataType:'JSON',
                success:function (response) {
                    if (response.status) {
                        $(this).parents('.item').fadeOut(300, function(){
                            $(this).undelegate('click');
                            $(this).remove();
                            $('.left-s .col').html(parseInt($('.left-s .col').html()) - 1);
                        });
                    }
                },
                context:$(this)
            });
        }
        return false;
    });*/

    $('body').delegate('a.edit-comment', 'click', function () {
        var id = $(this).parents('.item').attr('id').replace(/comment_/g, '');
        $('#edit-id').val(id);
        var editor = CKEDITOR.instances['Comment[text]'];
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
        <div class="text"></div>
    </div>
    <div class="quote">
        <input type="hidden" id="Comment_quote_id" name="Comment[quote_id]" value="" />
        <div class="text"></div>
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