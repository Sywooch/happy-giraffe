<?php
/** @var ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('ko_photo');
?>

<div class="layout-wrapper_frame clearfix">
    <div class="layout-wrapper_hold clearfix">
        <div class="layout-content clearfix">
            <div id="test">
                <p><a data-bind="photoUpload: { data : { multiple : false } }">Загрузить одно фото</a></p>
            </div>
        </div>
    </div>
</div>

<div id="photo"></div>

<script type="text/javascript">
    function TestViewModel() {
        var self = this;
        self.photo = ko.observable(null);
    }

    $(function () {
        test = new TestViewModel();
        ko.applyBindings(test, document.getElementById('test'));
    });
</script>

