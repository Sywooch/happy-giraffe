<?php
    Yii::import('application.controllers.AlbumsController');
    AlbumsController::loadUploadScritps();
    $link = Yii::app()->createUrl('/albums/addPhoto')
?>
<div class="user-photo-add user-add">
    <a href="<?php echo $link; ?>" class="fancy"><img src="/images/user_photo_add.png"></a>
    <a href="<?php echo $link; ?>" class="fancy">Я хочу<br>загрузить<br>фото!</a>
</div>