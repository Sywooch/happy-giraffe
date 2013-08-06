<?php
$model = new AlbumPhoto();
?><div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo" style="display: none;">
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Фотоальбом</label>

            <div class="w-400 float-l">
                <div class="chzn-itx-simple">
                    <select name="<?=CHtml::activeName($model, 'album_id')?>" id="<?=CHtml::activeId($model, 'album_id')?>" data-bind="options: albumsList,
                        value: selectedAlbum,
                        optionsText: function(album) {
                            return album.title;
                        },
                        optionsValue: function(album) {
                            return album.id;
                        },
                        chosenAlbum: {}"></select>
                    <?=CHtml::error($model, 'album_id')?>
                </div>
            </div>
        </div>
    </div>

    <div class="b-add-img b-add-img__for-multi">
        <div class="b-add-img_hold">
            <div class="b-add-img_t">
                Загрузите фотографии с компьютера
                <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
            </div>
            <div class="file-fake">
                <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                <input type="file" class="js-upload-files-multiple" multiple/>
            </div>
        </div>
        <div class="textalign-c clearfix">
            <!-- ko with: upload -->
            <!-- ko foreach: photos -->
            <div class="b-add-img_i" data-bind="attr: {id: 'uploaded_photo_' + uid}">
                <div class="js-image" style="opacity: 0.2"></div>
                <div class="b-add-img_i-vert"></div>
                <div class="b-add-img_i-load">
                    <div class="b-add-img_i-load-progress" data-bind="style: {width: progress}"></div>
                </div>
                <div class="b-add-img_i-overlay">
                    <a href="" class="b-add-img_i-del ico-close4" data-bind="click: remove"></a>
                </div>
            </div>
            <!-- /ko -->
            <!-- /ko -->
        </div>

        <!-- ko if: upload().photos().length == 0 -->
        <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
        <!-- /ko -->
    </div>

    <div class=" clearfix">
        <a href="" class="btn-blue btn-h46 float-r" data-bind="click: add, css: {'btn-inactive': upload().photos().length == 0}">Добавить</a>
        <a href="javascript:;" class="btn-gray-light btn-h46 float-r margin-r15" onclick="$.fancybox.close()">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    ko.bindingHandlers.chosenAlbum =
    {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
        {
            $(element).addClass('chzn');
            $(element).chosen().ready(function(){
                $('#popup-user-add-photo .chzn-itx-simple').find('.chzn-drop').append('<div class="chzn-itx-simple_add" id="albumAddForm"><div class="chzn-itx-simple_add-hold"> <input type="text" class="chzn-itx-simple_add-itx" data-bind="value: newAlbumTitle, valueUpdate: \'keyup\'"> <a class="chzn-itx-simple_add-del" data-bind="visible: newAlbumTitle().length > 0, click: clearNewAlbumTitle"></a> </div> <button class="btn-green" data-bind="click: createAlbum">Ok</button> </div>');
                ko.applyBindings(viewModel, document.getElementById('albumAddForm'));
            });
        },
        update: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
        {
            $(element).trigger('liszt:updated');
        }
    };

    var PhotoAlbumViewModel = function (data) {
        var self = this;
        self.id = 0;
        self.upload = ko.observable(new UploadPhotos());
        self.showDropdown = ko.observable(false);
        self.newAlbumTitle = ko.observable('');
        self.albumsList = ko.observableArray(ko.utils.arrayMap(data.albumsList, function(album) {
            return new UserAlbum(album);
        }));
        self.selectedAlbum = ko.observable(data.albumsList[0]);

        self.clearNewAlbumTitle = function() {
            self.newAlbumTitle('');
        };

        self.createAlbum = function() {
            $.post('/blog/default/createAlbum/', { title : self.newAlbumTitle() }, function(response) {
                if (response.success) {
                    self.albumsList.push(new UserAlbum({ id : response.id, title : self.newAlbumTitle() }));
                    self.selectedAlbum(response.id);
                    self.newAlbumTitle('');
                    $('body').click();
                }
            }, 'json');
        };

        self.toggleDropdown = function() {
            self.showDropdown(! self.showDropdown());
        };

        self.add = function () {
            if (self.upload().photos().length > 0){
                var photo_ids = [];
                var a = self.upload().photos();
                for (var i = 0; i < a.length; i++){
                    photo_ids.push(a[i].id());
                }

                $.post('/ajaxSimple/addPhoto/', {album_id: self.id, photo_ids: photo_ids}, function (response) {
                    if (response.status)
                        $.fancybox.close();
                }, 'json');
            }
        }
    };

    var UserAlbum = function(data) {
        var self = this;
        self.id = data.id;
        self.title = data.title;
    }


    var formVM2 = new PhotoAlbumViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(formVM2, document.getElementById('popup-user-add-photo'));
</script>