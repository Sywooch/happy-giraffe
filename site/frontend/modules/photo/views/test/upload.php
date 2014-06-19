<?php
/** @var ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('ko_photo');
?>

<div class="layout-wrapper_frame clearfix">
    <div class="layout-wrapper_hold clearfix">
        <div class="layout-content clearfix">
            <div id="test">
                <a data-bind="photoUpload: null">Загрузить фото</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function TestViewModel() {
        var self = this;
    }

    $(function () {
        ko.applyBindings(new TestViewModel(), document.getElementById('test'));
    });
</script>

