<h5>Добавление фото в альбом</h5>
<?php
$file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget', array(
    'album_id' => $album->id,
));
$file_upload->form();
$this->endWidget();
?>