<?php
$model = new AlbumPhoto();
?><div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo" style="display: none;">

    <?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
        'id' => 'album-form',
        'action' => '/ajaxSimple/albumValidate/',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => new CJavaScriptExpression('js:function(form, data, hasError) {
                if (!hasError)
                    photoFormVM.add();
                return false;
        }'),
        ),
    )); ?>

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
                        chosenAlbum: {}" data-placeholder="Выберите альбом или создайте новый"></select>
                    <?=$form->error($model, 'album_id')?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->renderPartial('application.views.upload_image_popup'); ?>

    <div class="clearfix textalign-r">
        <!-- ko if: upload().photos().length == 0 -->
        <?=$form->hiddenField($model, 'id')?>
        <?=$form->error($model, 'id') ?>
        <!-- /ko -->
    </div>

    <div class=" clearfix">
        <button class="btn-blue btn-h46 float-r btn-inactive" data-bind="css: {'btn-inactive': upload().photos().length == 0}"><?=$model->isNewRecord ? 'Добавить' : 'Редактировать'?></button>
        <a href="javascript:;" class="btn-gray-light btn-h46 float-r margin-r15" onclick="$.fancybox.close()">Отменить</a>
    </div>

    <?php $this->endWidget(); ?>
</div>

<?php
/**
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;

$js = <<<JS
    ko.bindingHandlers.chosenAlbum =
    {
        init: function(element, valueAccessor, allBindingsAccessor, viewModel, bindingContext)
        {
            viewModel.albumsList.unshift(new UserAlbum({ id : undefined, title : undefined }));
            $(element).addClass('chzn');
            $(element).chosen().ready(function(){
                $('#popup-user-add-photo .chzn-itx-simple').find('.chzn-drop').append('<div class="chzn-itx-simple_add" id="albumAddForm"><div class="chzn-itx-simple_add-hold"> <input type="text" class="chzn-itx-simple_add-itx" placeholder="Создайте новый" data-bind="value: newAlbumTitle, valueUpdate: \'keyup\'"> <a class="chzn-itx-simple_add-del" data-bind="visible: newAlbumTitle().length > 0, click: clearNewAlbumTitle"></a> </div> <button class="btn-green" data-bind="click: createAlbum">Ok</button> </div>');
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
        self.upload = ko.observable(new UploadPhotos(null, true, '#popup-user-add-photo'));
        self.showDropdown = ko.observable(false);
        self.newAlbumTitle = ko.observable('');
        self.albumsList = ko.observableArray(ko.utils.arrayMap(data.albumsList, function(album) {
            return new UserAlbum(album);
        }));
        self.selectedAlbum = ko.observable(data.albumsList.length > 1 ? undefined : data.albumsList[0]);

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

                $.post('/ajaxSimple/addPhoto/', {album_id: self.selectedAlbum(), photo_ids: photo_ids}, function (response) {
                    if (response.status)
                        location.href = response.redirectUrl;
                }, 'json');
            }
        }
    };

    var UserAlbum = function(data) {
        var self = this;
        self.id = data.id;
        self.title = data.title;
    };
JS;

$js .= "ko.applyBindings(new PhotoAlbumViewModel(" . CJSON::encode($json) . "), document.getElementById('popup-user-add-photo'));";

if ($cs->useAMD) {
    $cs->registerAMD('add-photoAlbum', array('ko' => 'knockout',  'ko_post' => 'ko_post'), $js);
} else {
    $cs->registerScript('add-photoAlbum', $js, ClientScript::POS_READY);
}
?>