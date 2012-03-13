<div class="popup" id="photoPick">
    <a onclick="$.fancybox.close();" class="popup-close" href="javascript:void(0);">закрыть</a>
    <div class="title">Фотография для конкурса «Осенние прогулки»</div>
    <div class="nav">
        <ul>
            <li class="active"><a href="">С компьютера</a></li>
            <li><a href="">Из моих альбомов</a></li>
        </ul>
    </div>
    <?php $this->render('_' . $view_type); ?>
</div>