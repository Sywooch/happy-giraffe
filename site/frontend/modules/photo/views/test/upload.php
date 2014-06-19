<?php
/** @var ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('ko_photo');
?>

<div id="test">
    <a data-bind="photoUpload: null">Загрузить фото</a>
</div>

<script type="text/javascript">
    function TestViewModel() {
        var self = this;
    }

    $(function () {
        ko.applyBindings(new TestViewModel(), document.getElementById('test'));
    });
</script>

