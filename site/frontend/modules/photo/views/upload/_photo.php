<script type="text/html" id="photo-template">
    <div class="i-photo" data-bind="css: cssClass"><a href="" class="ico-close5" data-bind="click: $parent.removePhoto"></a>
        <!-- ko if: status() == PhotoUpload.STATUS_SUCCESS -->
        <div class="i-photo_hold">
            <div class="i-photo_img-hold"><img src="" alt="" class="i-photo_img" data-bind="thumb: { photo: $data, preset: 'uploadMin' }">
                <div class="i-photo_overlay"><a href="" class="i-photo_rotate" data-bind="click: rotateLeft"></a><a href="" class="i-photo_rotate i-photo_rotate__r" data-bind="click: rotateRight"></a></div>
            </div>
            <input type="text" placeholder="Введите заголовок" class="i-photo_itx itx-gray">
        </div>
        <!-- /ko -->

        <!-- ko if: status() == PhotoUpload.STATUS_LOADING -->
        <div class="i-photo_hold">
            <div class="i-photo_progress">
                <div class="progress progress-striped active progress__cont">
                    <div role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" class="progress-bar progress-bar__cont"></div>
                </div>
                <div class="tx-hint">Загрузка</div>
            </div>
        </div>
        <!-- /ko -->

        <!-- ko if: status() == PhotoUpload.STATUS_FAIL -->
        <div class="i-photo_hold error">
            <div class="tx-hint" data-bind="text: original_name"></div>
            <div class="tx-hint">Ошибка загрузки</div>
        </div>
        <!-- /ko -->
    </div>
</script>