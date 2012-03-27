<?php
/**
 * User: alexk984
 * Date: 04.03.12
 */
Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.tmpl.min.js');
?>
<ul>
    <? foreach ($rubrics as $r): ?>
    <?php $this->renderPartial('parts/rubric_item', array(
        'r' => $r,
    )); ?>
    <? endforeach; ?>
</ul>
<?php if (Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->id, array('community_id' => $community->id)))
    echo CHtml::link('<i class="icon"></i>', '', array('class' => 'add'));?>

<script id="edit_rubric_tmpl" type="text/x-jquery-tmpl">
    <form class="edit-form">
        <input type="text" value="${name}">
        <button class="btn btn-green-small"><span><span>Ок</span></span></button>
    </form>
</script>
<?php
Yii::app()->clientScript->registerScript('edit_rubrics_main', "
    $('body').delegate('.club-topics-list ul li a.edit', 'click', function () {
        var name = $(this).next().text();
        $(this).hide();
        $(this).next().hide();
        $(this).parent().append($('#edit_rubric_tmpl').tmpl({name:name}));
        return false;
    });

    $('body').delegate('.club-topics-list ul li  form.edit-form button', 'click', function () {
        var id = $(this).parent().parent().find('input.rubric-id').val();
        var text = $(this).prev().val();
        $.ajax({
            url:'" . Yii::app()->createUrl("communityRubric/update") . "',
            data:{id:id, name:text},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(this).parent().prev().text(text);
                    $(this).parent().prev().show();
                    $(this).parent().prev().prev().show().removeAttr('style');
                    $(this).parent().remove();
                } else {
                    alert('Ошибка, обратитесь к разработчикам');
                }
            },
            context:$(this)
        });
        return false;
    });

    $('.club-topics-list a.add').click(function () {
        $(this).hide();
        $(this).parents('.club-topics-list').append($('#edit_rubric_tmpl').tmpl({name:''}));
        return false;
    });

    $('body').delegate('div.club-topics-list > .edit-form > button', 'click', function () {
        var text = $(this).prev().val();
        $.ajax({
            url:'" . Yii::app()->createUrl("communityRubric/create") . "',
            data:{name:text, community_id:'" . $this->community->id . "', content_type_slug:'" . $this->content_type_slug . "'},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(this).parent().parent().find('ul').append(response.html);
                    $(this).parent().prev().show();
                    $(this).parent().prev().prev().show();
                    $(this).parent().remove();
                } else {
                    alert('Ошибка, обратитесь к разработчикам');
                }
            },
            context:$(this)
        });
        return false;
    });
");
?>