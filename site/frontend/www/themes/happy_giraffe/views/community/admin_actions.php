<?php if (Yii::app()->user->checkAccess('editCommunityContent', array('community_id' => $c->rubric->community->id, 'user_id' => $c->contentAuthor->id))
    || Yii::app()->user->checkAccess('removeCommunityContent', array('community_id' => $c->rubric->community->id, 'user_id' => $c->contentAuthor->id))
): ?>
<div class="admin-actions">

    <?php if (Yii::app()->user->checkAccess('editCommunityContent', array('community_id' => $c->rubric->community->id, 'user_id' => $c->contentAuthor->id))): ?>
    <?php echo CHtml::link('<i class="icon"></i>', ($c->type->slug == 'travel') ?
        $this->createUrl('community/editTravel', array('id' => $c->id))
        :
        $this->createUrl('community/edit', array('content_id' => $c->id)), array('class' => 'edit')); ?>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('transfer post')): ?>
    <input type="hidden" value="<?php echo $c->id ?>">
    <a href="#movePost" class="move fancy">Переместить</a>
    <?php endif; ?>

    <?php if (Yii::app()->user->checkAccess('removeCommunityContent', array('community_id' => $c->rubric->community->id, 'user_id' => $c->contentAuthor->id))): ?>
    <?php $this->widget('site.frontend.widgets.removeWidget.RemoveWidget', array(
        'model' => $c,
        'callback' => 'CommunityContentRemove',
        'author' => !Yii::app()->user->isGuest && Yii::app()->user->id == $c->author_id
    ));
    Yii::app()->clientScript->registerScript('register_after_removeContent', '
        function CommunityContentRemove() {window.location.reload();}
        function CommunityContentRemove() {
            window.location = "' . Yii::app()->createUrl('community/list', array(
        'community_id' => $c->rubric->community->id,
        'content_type_slug' => $c->type->slug)) . '";}', CClientScript::POS_HEAD);
    ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php
$js = '
    $(".admin-actions .move").click(function () {
        $.fancybox.open($("#transfer_post").tmpl());
        $("#active_post_id").val($(this).prev().val());
        //$("#movePost select").chosen();
        return false;
    });

    $("body").delegate("#movePost button.btn-green-medium", "click", function () {
        $.ajax({
            url:"' . Yii::app()->createUrl("community/transfer") . '",
            data:{
                id:$("#active_post_id").val(),
                CommunityContent:{
                    community_id:$("#community_id").val(),
                    rubric_id:$("#rubric_id").val()
                }
            },
            type:"POST",
            dataType:"JSON",
            success:function (response) {
                if (response.status) {
                    //confirmMessage(this);
                    window.location = response.url;
                }
            },
            context:$(this)
        });
        return false;
    });';
Yii::app()->clientScript->registerScript('move-post', $js);
?>