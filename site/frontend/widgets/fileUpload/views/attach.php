<div class="file-fake">
    <form id="attach_form" action="<?php echo Yii::app()->createUrl('/albums/addPhoto', array('a' => $this->album_id)) ?>" method="post" enctype="multipart/form-data">
        <button class="btn btn-orange"><span><span>Обзор...</span></span></button>
        <input type="file" name="Filedata" onchange="$(this).parent().trigger('submit');" />
    </form>
</div>
<script type="text/javascript">
    initAttachForm();
</script>