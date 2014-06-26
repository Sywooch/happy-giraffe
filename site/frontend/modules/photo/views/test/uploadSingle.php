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

                <div data-bind="with: photo">
                    <p>Прямая ссылка: <a data-bind="attr: { href : imageUrl }, text: imageUrl"></a></p>
                    <p>Изображение: <img data-bind="attr: { src : imageUrl }"></p>
                    <p>Оригинальное имя: <span data-bind="text: original_name"></span></p>
                    <p>Ширина: <span data-bind="text: width"></span></p>
                    <p>Высота: <span data-bind="text: height"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

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

