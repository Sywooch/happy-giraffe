<?php
/**
 * User: alexk984
 * Date: 04.03.12
 */
Yii::app()->clientScript->registerScriptFile('/javascripts/jquery.tmpl.min.js');
?>
<div class="club-topics-list">
    <div class="theme-pic">Рубрики</div>
    <ul>
        <? foreach ($community->rubrics as $r): ?>
        <?php $this->renderPartial('parts/rubric_item', array(
            'r' => $r,
            'current_rubric' => $current_rubric,
            'content_type_slug' => ($content_type !== null) ? $content_type->slug : null
        )); ?>
        <? endforeach; ?>
    </ul>
    <?php if (Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->getId(), array('community_id' => $community->id)))
    echo CHtml::link('<i class="icon"></i>', '', array('class' => 'add'));?>
</div>
<script id="edit_rubric_tmpl" type="text/x-jquery-tmpl">
    <form class="edit-form">
        <input type="text" value="${name}">
        <button class="btn btn-green-small"><span><span>Ок</span></span></button>
    </form>
</script>

<script type="text/javascript">
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
            url:'<?php echo Yii::app()->createUrl("communityRubric/update") ?>',
            data:{id:id, name:text},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    $(this).parent().prev().text(text);
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

    $('.club-topics-list a.add').click(function () {
        $(this).hide();
        $(this).parents('.club-topics-list').append($('#edit_rubric_tmpl').tmpl({name:''}));
        return false;
    });

    $('body').delegate('div.club-topics-list > .edit-form > button', 'click', function () {
        var text = $(this).prev().val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("communityRubric/create") ?>',
            data:{name:text, community_id:'<?php echo $community->id ?>', content_type_slug:'<?php echo ($content_type === null) ? '' : $content_type->slug ?>'},
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
</script>