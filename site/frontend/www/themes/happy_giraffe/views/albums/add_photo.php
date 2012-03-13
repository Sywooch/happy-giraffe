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
                <div class="text">Загрузите файл (jpeg, png, gif не более 4 Мб)</div>
            </li>
        </ul>
    </div>

    <div class="bottom">
        <?php
        $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget', array(
            'album_id' => $album ? $album->id : false,
        ));
        $file_upload->form();
        $this->endWidget();
        ?>

        <div class="file-fake">
            <a href="" class="btn btn-green-medium"><span><span>Обзор...</span></span></a>
            <input type="file" />
        </div>
    </div>

    <br/>
    <br/>

    <div class="title">Загружено  78%</div>

    <div class="upload-files-list scroll">
        <ul id="log"></ul>
    </div>

    <div class="bottom">

        <a href="" class="a-left">Добавить еще фотографий</a>
        <a href="" class="btn btn-gray-medium"><span><span>Завершить</span></span></a>

    </div>

    <div class="bottom">

        <a href="" class="a-left">Добавить еще фотографий</a>
        <a href="" class="btn btn-green-medium"><span><span>Завершить</span></span></a>

    </div>

</div>
    <script type="text/javascript">
        setTimeout(function(){$('.scroll').scrollbarPaper();}, 500)
    </script>