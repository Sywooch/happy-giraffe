<div id="galleryUploadPhotos" class="popup">

    <a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

    <div class="title">Добавьте Ваши фото</div>

    <div class="teasers clearfix">
        <ul>
            <li>
                <div class="img"><img src="/images/upload_teaser_img_01.png" /></div>
                <div class="text">Чтобы загрузить сразу несколько фото, нажмите и удерживайте кнопку Control при выборе фото.</div>
            </li>
            <li>
                <div class="img"><div class="max-size"><div class="in">jpeg<br/>6 Мб</div></div></div>
                <div class="text">Загрузите файл (jpeg, png, gif не более 6 Мб)</div>
            </li>
        </ul>
    </div>

    <div class="bottom" id="upload_button_wrapper">
        <?php
        $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget', array(
            'album_id' => $album ? $album->id : false,
        ));
        $file_upload->form();
        $this->endWidget();
        ?>
    </div>

    <br/>
    <br/>

    <div class="upload-files-list scroll">
        <ul id="log"></ul>
    </div>

    <div class="bottom" style="display: none;" id="upload_finish_wrapper">
        <a href="" class="a-left" id="upload-link">Добавить еще фотографий</a>
        <a href="" class="btn btn-green-medium" onclick="return savePhotos();"><span><span>Завершить</span></span></a>
    </div>

</div>
    <script type="text/javascript">
        setTimeout(function(){$('.scroll').scrollbarPaper();}, 500)
    </script>