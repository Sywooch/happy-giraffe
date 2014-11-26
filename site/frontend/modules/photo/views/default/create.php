<?php
$this->pageTitle = 'Создание фотоальбома' ;
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-albums-create', array('kow'));
?>

<div class="b-main_cont">
    <photo-albums-create>
        <div class="b-album_img-hold" style="height: 350px; width: 560px; margin-top: 10px;">
            <div class="img-grid_loading-hold">
                <div class="loader-circle">
                    <div class="loader-circle_hold">
                        <div class="loader-circle_1"></div>
                        <div class="loader-circle_2"></div>
                    </div>
                </div>
                <div class="img-grid_loading-tx">Загрузка создания</div>
            </div>
        </div>
    </photo-albums-create>
</div>