<?php
/** @var ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('jquery_file_upload');
?>

<input id="fileupload" type="file" name="files[]" multiple>

<script type="text/javascript">
    $(function () {
        $('#fileupload').fileupload({
            url: '/photo/upload/fromComputer/',
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo(document.body);
                });
            }
        });
    });
</script>