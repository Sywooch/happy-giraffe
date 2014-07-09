<div class="layout-wrapper_frame clearfix">
    <div class="layout-wrapper_hold clearfix">
        <div class="layout-content clearfix">
            <div id="test">
                <p><a data-bind="photoUpload: { data: { multiple : false }, observable: photo }">Загрузить одно фото</a></p>

                <div data-bind="with: photo">
                    <p>ID: <span data-bind="text: id"></span></p>
                    <p>Прямая ссылка: <a data-bind="attr: { href : originalUrl }, text: originalUrl"></a></p>
                    <p>Изображение: <img data-bind="attr: { src : originalUrl }"></p>
                    <p>Оригинальное имя: <span data-bind="text: original_name"></span></p>
                    <p>Ширина: <span data-bind="text: width"></span></p>
                    <p>Высота: <span data-bind="text: height"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    require(['knockout', 'ko_photoUpload'], function(ko) {
        function TestViewModel() {
            var self = this;
            self.photo = ko.observable(null);
            self.photos = ko.observableArray([]);
        }

        ko.applyBindings(new TestViewModel(), document.getElementById('test'));
    });


</script>

