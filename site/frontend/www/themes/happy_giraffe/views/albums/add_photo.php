<div id="galleryUploadPhotos" class="popup">
    <a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>

    <div class="popup-title">Загрузка фотографий</div>

    <div id="album_upload_step_1">
        <div class="title">Шаг 1</div>
        <table>
            <tbody>
                <tr>
                    <td>
                        <big>Выберите альбом</big>
                        <?php echo CHtml::dropDownList('album_id', $album ? $album->id : false, CHtml::listData(Yii::app()->user->model->albums('albums:noSystem'), 'id', 'title'), array('class' => 'chzn chzn-deselect w-200', 'id' => 'album_select', 'data-placeholder' => 'Выбрать альбом', 'empty' => '', 'onchange' => 'Album.changeAlbum(this);')) ?>
                    </td>
                    <td width="120" align="center"><big>или</big></td>
                    <td>
                        <big>Создайте новый</big>
                        <input type="text" placeholder="Введите название нового альбома" id="new_album_title" class="album-name" onkeyup="Album.changeAlbumTitle(this);" />
                        <input type="hidden" id="author_id" value="<?php echo Yii::app()->user->id ?>" />
                    </td>
                </tr>
            </tbody>
        </table>

        <br/><br/>

        <div class="title">Шаг 2</div>

        <div class="teasers clearfix">
            <ul>
                <li>
                    <div class="img"><img src="/images/upload_teaser_img_01.png" /></div>
                    <div class="text">Чтобы загрузить сразу несколько фото, нажмите и удерживайте кнопку Control при выборе фото.</div>
                </li>
                <li>
                    <div class="img"><div class="max-size"><div class="in">6 Мб</div></div></div>
                    <div class="text">Загрузите файл (jpeg, png, gif не более 6 Мб)</div>
                </li>
            </ul>
        </div>

        <div class="bottom<?php echo !$album ? ' disabled' : '' ?>" id="upload_button_wrapper">
            <?php
            $file_upload = $this->beginWidget('site.frontend.widgets.fileUpload.FileUploadWidget', array(
                'album_id' => $album ? $album->id : false,
            ));
            $file_upload->form($album ? true : false);
            $this->endWidget();
            ?>
        </div>
    </div>

    <div id="album_upload_step_2">

        <div class="upload-files-list scroll">
            <ul id="log"></ul>
        </div>

        <div class="bottom" style="overflow:hidden;height:0;" id="upload_finish_wrapper">
            <a href="" class="a-left" id="upload-link">Добавить еще фотографий</a>
            <a href="" class="btn btn-green-medium" onclick="return Album.savePhotos();"><span><span>Завершить</span></span></a>
        </div>
    </div>
</div>
    <script type="text/javascript">
        setTimeout(function(){$('.scroll').scrollbarPaper();}, 500)
    </script>