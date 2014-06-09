<?php
/** @var ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('ko_photo');
?>

<style>
    .photo {
        display: inline-block;
        width: 200px;
        height: 200px;
        border: 1px #000 solid;
    }

    .photo-pending {
        background-color: #ccc;
    }

    .photo-fail {
        background-color: red;
    }

    .photo-success {
        background-color: green;
    }
</style>

<?php echo CHtml::form(array('/photo/upload/fromComputer'), 'post', array('enctype' => 'multipart/form-data')); ?>
<input id="fileupload" type="file" name="files[]" multiple>
<?php echo CHtml::endForm(); ?>

<div id="upload">
    <!-- ko foreach: photos -->
        <div class="photo" data-bind="css: cssClass">
            <!-- ko if: status() == STATUS_SUCCESS -->
            <img src="" data-bind="attr: { src : originalPath }">
            <!-- /ko -->
        </div>
    <!-- /ko -->
</div>

<script type="text/javascript">
    $(function () {
        uploadVM = PhotoUploadViewModel($('#fileupload'));
        ko.applyBindings(uploadVM, document.getElementById('upload'));
    });
</script>