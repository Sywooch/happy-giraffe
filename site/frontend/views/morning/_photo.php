<div class="clearfix">
    <div style="float:left;position: relative;"><img src="<?=$photo->getUrl() ?>" alt="">
        <?php echo CHtml::hiddenField('id', $photo->id, array('class'=>'photo-id')); ?>
        <a href="" class="remove"></a>
    </div>
    <div style="margin-left:240px;">
        <div class="text"<?php if (empty($photo->text)) echo ' style="display:none;"' ?>><?=$photo->text ?></div>
        <div class="input"<?php if (!empty($photo->text)) echo ' style="display:none;"' ?>>
            <textarea rows="5" cols="35"></textarea>
            <button class="btn btn-green-small" onclick="Morniing.saveSomeField(this, 'text', 'CommunityPhoto', <?=$photo->id ?>);"><span><span>Ok</span></span>
            </button>
        </div>
        <a href="javascript:void(0);" onclick="Morniing.editField(this)"
           class="edit tooltip"<?php if (empty($photo->text)) echo ' style="display:none;"' ?> title="Редактировать текст"></a>
    </div>
</div>