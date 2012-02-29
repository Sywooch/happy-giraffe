<?php
$cs = Yii::app()->clientScript;
$js = "
$('button.cancel').live('click', function(e) {
	e.preventDefault();
	var editor = CKEDITOR.instances['Comment[text]'];
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
                $.ajax({
                    type: 'POST',
                    data: {
                        entity: $('#Comment_entity').val(),
                        entity_id: $('#Comment_entity_id').val()
                    },
                    url: " . CJSON::encode(Yii::app()->createUrl('ajax/showcomments')) . ",
                    success: function(response) {
                        $('div.comments').replaceWith(response);
                        if ($('#edit-id').val() != ''){
			                $('html,body').animate({scrollTop: $('#CommunityComment_' + $('#edit-id').val()).offset().top},'fast');
                        }else{
                            $('div.comments div.item:first').hide();
                            $('html,body').animate({scrollTop: $('div.comments').offset().top},'slow',function() {
                                $('div.comments div.item:first').fadeIn(1000);
                            });
                        }
                        endEdit();
                    }
                });
				var editor = CKEDITOR.instances['Comment[text]'];
                editor.setData('');
			}
		},
	});
});

$('body').delegate('a.remove-comment', 'click', function () {
        if (confirm('Вы точно хотите удалить комментарий?')) {
            var id = $(this).parents('.item').attr('id').replace(/CommunityComment_/g, '');
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
    });

    $('body').delegate('a.edit-comment', 'click', function () {
        var id = $(this).parents('.item').attr('id').replace(/CommunityComment_/g, '');
        $('#edit-id').val(id);
        var editor = CKEDITOR.instances['Comment[text]'];
        editor.setData($(this).parents('.item').find('.comment-content').html());
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