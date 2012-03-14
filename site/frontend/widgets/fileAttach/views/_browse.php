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
        <div class="note">Загрузите файл<br>(jpg, gif, png не более 4 МБ)</div>
    </div>
    <div class="form-bottom">
        <button class="btn btn-green-medium"><span><span>Добавить на конкурс</span></span></button>
    </div>
</div>