<div class="form">
    <div class="photo-upload clearfix">
        <div class="photo">
            <div class="in">
                <div class="file-fake">
                    <form id="attach_form" action="<?php echo Yii::app()->createUrl('/albums/addPhoto') ?>" method="post" enctype="multipart/form-data">
                        <button class="btn btn-orange"><span><span>Обзор...</span></span></button>
                        <input type="file" name="Filedata" onchange="$(this).parent().trigger('submit');" />
                    </form>
                </div>
                <script type="text/javascript">
                    initAttachForm();
                </script>
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
        <button class="btn btn-green-medium" onclick="return <?php echo $this->id; ?>.selectBrowsePhoto(this);"><span><span><?php echo $this->button_title; ?></span></span></button>
    </div>
</div>