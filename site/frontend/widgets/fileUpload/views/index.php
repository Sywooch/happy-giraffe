<?php echo CHtml::form('', 'post', array('id' => 'upload-form', 'enctype' => 'multipart/form-data')); ?>
<div class="profile-form-in" id="upload-control">
    <p><?php echo CHtml::fileField('file', '', array('id' => $this->id, 'id' => 'upload-input', 'multiple' => 'multiple')); ?></p>
    <div class="row-btn-left">
        <button class="btn btn-orange" id="upload-button"><span><span>Загрузить</span></span>
    </div>
    <p id="queuestatus" ></p>
    <ol id="log"></ol>
</div>
<?php echo CHtml::endForm(); ?>
<script type="text/javascript">initForm();</script>