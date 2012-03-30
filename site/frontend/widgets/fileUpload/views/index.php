<div class="profile-form-in" id="upload-control">
    <p><?php echo CHtml::fileField('file', '', array('id' => $this->id, 'id' => 'upload-input', 'multiple' => 'multiple')); ?></p>
    <div class="row-btn-left">
        <button class="btn btn-orange" id="upload-button"><span><span>Загрузить</span></span>
    </div>
</div>