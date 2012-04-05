<div class="form">
    <div class="photo-upload clearfix">
        <div class="text">Фото</div>
        <div class="photo">
            <div class="in">
                <?php
                $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget', array(
                    'album_id' => false,
                    'mode' => 'attach',
                ));
                $file_upload->form();
                $this->endWidget();
                ?>
                <div id="upload_photo_container"></div>
            </div>
        </div>
        <div class="note">Загрузите файл<br>(jpg, gif, png не более 6 МБ)</div>
        <?php if($this->entity == 'Comment'): ?>
            <div class="photo_title" style="display:none;">
                <label>Название изображения</label>
                <br/>
                <input type="text" placeholder="Введите название" id="photo_title" />
            </div>
        <?php endif; ?>
    </div>
    <div class="form-bottom" id="save_attach_button" style="display:none;">
        <button class="btn btn-green-medium" onclick="return Attach.selectBrowsePhoto(this);"><span><span><?php echo $this->button_title; ?></span></span></button>
    </div>
</div>