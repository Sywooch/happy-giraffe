<script>
    document.domain = 'www.virtual-giraffe.ru';
</script>

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
            $js = "var upload_ajax_url = '" . Yii::app()->createUrl('/albums/addPhoto', array('a' => $album ? $album->id : false)) . "';";
            if($album)
                $js .= "Album.album_id = " . $album->id . ";Album.current_album_id = " . $album->id . ";";
            Yii::app()->clientScript->registerScript('upload_ajax_url', $js, CClientScript::POS_HEAD);
            ?>
            <?php echo CHtml::form('', 'post', array('id' => 'upload-form', 'enctype' => 'multipart/form-data')); ?>

            <div class="profile-form-in" id="upload-control">
                <p><?php echo CHtml::fileField('file', '', array('id' => 'upload-input', 'multiple' => 'multiple', 'style' => 'display:none;')); ?></p>
                <div class="row-btn-left">
                    <div class="file-fake" id="upload-file-fake" style="display:none;">
                        <button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
                        <input type="file" class="j-upload-input" id="j-upload-input1" name="Filedata" multiple="multiple" />
                    </div>
                    <button class="btn btn-orange" id="upload-button" style="display: none;"><span><span>Загрузить</span></span></button>
                </div>
            </div>
            <?php echo CHtml::endForm(); ?>
            <?php if($album): ?>
                <script type="text/javascript">
                    Album.initUploadForm();
                </script>
            <?php endif; ?>

        </div>
    </div>

    <div id="album_upload_step_2" style="display: none;">
        <div class="upload-files-list-container">
            <div class="upload-files-list scroll">
                <ul id="log"></ul>
            </div>
        </div>
        <div class="bottom" style="overflow:hidden;height:0;" id="upload_finish_wrapper">
            <a href="javascript:;" class="a-left" id="upload-link">Добавить еще фотографий</a>
            <a href="javascript:;" class="btn btn-green-medium" onclick="return Album.savePhotos();"><span><span>Завершить</span></span></a>
        </div>
    </div>
</div>