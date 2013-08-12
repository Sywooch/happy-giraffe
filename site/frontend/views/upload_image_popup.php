<!-- ko with: upload -->
<div class="b-add-img" data-bind="attr: {'class': 'b-add-img ' + multiClass() }">
    <div class="b-add-img_hold">
        <div class="b-add-img_t">
            Загрузите фотографии с компьютера
            <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
        </div>
        <div class="file-fake">
            <button class="btn-green btn-medium file-fake_btn" data-bind="css: {'btn-inactive': !loadActive()}">Обзор</button>
            <!-- ko if: !multi() -->
            <input type="file" class="js-upload-files-multiple" data-bind="click: openLoad">
            <!-- /ko -->
            <!-- ko if: multi() -->
            <input type="file" class="js-upload-files-multiple" multiple/>
            <!-- /ko -->
        </div>
    </div>
    <div class="textalign-c clearfix">
        <!-- ko foreach: photos -->
        <div class="b-add-img_i" data-bind="attr: {id: 'uploaded_photo_' + uid}, css: {'b-add-img_i__single': isSingle(), 'error': isError()}" style="overflow: hidden;">

            <!-- ko if: isError() -->
            <div class="b-add-img_i-error-tx" data-bind="text: error"></div>
            <!-- /ko -->

            <div class="js-image" style="opacity: 0.2"></div>

            <!-- ko if: file === null  -->
            <img class="b-add-img_i-img" data-bind="attr: {src: url}">
            <!-- /ko -->

            <!-- ko if: !isError() -->
            <div class="b-add-img_i-vert"></div>
            <!-- ko if: status() != 2 -->
            <div class="b-add-img_i-load">
                <div class="b-add-img_i-load-progress" data-bind="style: {width: progress}"></div>
            </div>
            <!-- /ko -->
            <!-- /ko -->

            <div class="b-add-img_i-overlay">
                <a href="" class="b-add-img_i-del ico-close4" data-bind="click: remove"></a>
            </div>
        </div>
        <!-- /ko -->
    </div>
    <!-- ko if: photos().length == 0 -->
    <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
    <!-- /ko -->
</div>
<!-- /ko -->