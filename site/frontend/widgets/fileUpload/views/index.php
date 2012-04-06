<?php echo CHtml::form('', 'post', array('id' => 'upload-form', 'enctype' => 'multipart/form-data')); ?>
<div class="profile-form-in" id="upload-control">
    <p><?php echo CHtml::fileField('file', '', array('id' => $this->id, 'id' => 'upload-input', 'multiple' => 'multiple', 'style' => 'display:none;')); ?></p>
    <div class="row-btn-left">
        <button class="btn btn-orange" id="upload-button" style="display: none;"><span><span>Загрузить</span></span></button>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<?php if($init === true): ?>
    <script type="text/javascript">initForm();</script>
<?php endif; ?>