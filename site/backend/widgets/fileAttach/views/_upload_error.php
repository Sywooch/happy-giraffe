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
        <div class="errorMessage">
            <?=$error ?>
        </div>
    </div>
</div>