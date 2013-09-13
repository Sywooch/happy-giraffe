<?php
Yii::app()->clientScript
    ->registerPackage('ko_family')
;
$this->widget('PhotoCollectionViewWidget', array('registerScripts' => true));
?>

<div class="content-cols clearfix" data-bind="with: mainVM">
    <div class="col-1">
        <?php $this->widget('Avatar', array('user' => $user, 'size' => 200, 'location' => true, 'age' => true)); ?>

        <div class="b-family b-family__bg-white">
            <div class="b-family_top b-family_top__blue"></div>
            <ul class="b-family_ul">
                <!-- ko template: { name : 'member-small-template', data : me } --><!-- /ko -->
                <!-- ko template: { name : 'member-small-template', data : partner, if : partner() !== null } --><!-- /ko-->
                <!-- ko template: { name : 'member-small-template', foreach : normalBabies } --><!-- /ko -->
                <!-- ko template: { name : 'member-small-template', data : waitingBaby, if : waitingBaby } --><!-- /ko -->
            </ul>
            <div class="textalign-c">
                <!-- Для удобства число можно положить в span или другой строчный тег -->
                <span class="font-big padding-r5"> Членов семьи: <span data-bind="text: familyMembersCount"></span> </span>
                <!-- ko if: canEdit -->
                    <a class="a-pseudo font-middle" data-bind="click: change">Изменить</a>
                <!-- /ko -->
            </div>
        </div>

    </div>

    <div class="col-23-middle clearfix">
        <div class="clearfix margin-r20">
            <div class="float-r position-r margin-t15">
                <span class="font-big padding-r5"> Членов семьи: <span data-bind="text: familyMembersCount"></span> </span>
                <!-- ko if: canEdit -->
                    <a class="a-pseudo font-middle" data-bind="click: change">Изменить</a>
                <!-- /ko -->
                <div data-bind="if: addIsOpened">
                    <?=$this->renderPartial('_add')?>
                </div>
            </div>
            <div class="heading-title">
                Моя семья
            </div>
        </div>
        <div class="col-gray padding-20">
            <!-- ko template: { name : 'member-template', data : me } --><!-- /ko -->
            <!-- ko template: { name : 'member-template', data : partner, if : partner() !== null } --><!-- /ko-->
            <!-- ko template: { name : 'member-template', foreach : normalBabies } --><!-- /ko -->
            <!-- ko template: { name : 'member-template', data : waitingBaby, if : waitingBaby } --><!-- /ko -->
        </div>
    </div>
</div>

<script type="text/javascript">
    var FamilyVM = function() {
        var self = this;
        self.mainVM = ko.observable(new FamilyMainViewModel(<?=CJSON::encode($json)?>));
        self.addVM = ko.observable(null);
    }

    $(function() {
        familyVM = new FamilyVM(<?=CJSON::encode($json)?>);
        ko.applyBindings(familyVM);
    });
</script>

<script type="text/html" id="member-template">
    <div class="family-settings clearfix">
        <!-- ko if: $parent.canEdit && ! ($data instanceof FamilyMainMe) -->
            <a class="ico-close2 powertip family-settings_del" title="Удалить" data-bind="click: remove"></a>
        <!-- /ko -->
        <!-- ko if: isRemoved -->
        <div class="cap-empty">
            <div class="cap-empty_hold">
                <div class="cap-empty_tx" data-bind="text: removedLabel()"></div>
                <a class="cap-empty_a" data-bind="click: restore">Восстановить</a>
            </div>
        </div>
        <!-- /ko -->
        <div class="family-settings_hold clearfix">
            <div class="family-settings_photo">
                <div class="family-settings_photo-hold">
                    <!-- ko if: photoToShow() !== null -->
                        <img alt="" class="family-settings_photo-img" data-bind="attr: { src : photoToShow().bigThumbSrc }">
                    <!-- /ko -->
                    <!-- ko if: photoToShow() === null -->
                        <div class="ico-family-big" data-bind="css: bigCssClass()"></div>
                    <!-- /ko -->
                </div>
            </div>
            <div class="family-settings_desc">
                <div class="form-settings">
                    <div class="form-settings_label-row" data-bind="text: titleLabel()"></div>
                    <!-- ko if: nameIsEditable -->
                        <div class="clearfix">
                            <div class="form-settings_elem">
                                <!-- ko if: ! nameBeingEdited() -->
                                    <span class="form-settings_name" data-bind="text: name, visible: name().length > 0"></span>
                                    <!-- ko if: $parent.canEdit -->
                                        <!-- ko if: name().length > 0 -->
                                            <a class="a-pseudo-icon powertip" title="Редактировать" data-bind="click: editName">
                                                <span class="ico-edit"></span>
                                            </a>
                                        <!-- /ko -->
                                        <!-- ko if: name().length == 0 -->
                                            <a class="a-pseudo-gray" data-bind="text: namePlaceholderLabel(), click: editName"></a>
                                        <!-- /ko -->
                                    <!-- /ko -->
                                <!-- /ko -->
                                <!-- ko if: nameBeingEdited -->
                                    <div class="float-l w-300">
                                        <input type="text" class="itx-gray" data-bind="value: nameValue, attr: { placeholder : namePlaceholderLabel() }">
                                    </div>
                                    <button class="btn-green btn-small margin-l10" data-bind="click: saveName">Ok</button>
                                <!-- /ko -->
                            </div>
                        </div>
                    <!-- /ko -->
                    <!-- ko if: $data instanceof FamilyMainBaby && $data.birthdayIsEditable -->
                        <div class="form-settings_label-row" data-bind="text: birthdayLabel()"></div>
                        <div class="clearfix">
                            <div class="form-settings_elem">
                                <!-- ko if: ! birthdayBeingEdited() -->
                                    <!-- ko if: birthday() !== null -->
                                        <span data-bind="text: birthdayText"></span>
                                    <!-- /ko -->
                                    <!-- ko if: $parent.canEdit && birthday() !== null -->
                                        <a class="a-pseudo-icon" data-bind="click: editBirthday">
                                            <span class="ico-edit"></span>
                                        </a>
                                    <!-- /ko -->
                                    <!-- ko if: $parent.canEdit && birthday() === null -->
                                        <a class="a-pseudo-gray" data-bind="text: birthdayPlaceholderLabel(), click: editBirthday"></a>
                                    <!-- /ko -->
                                <!-- /ko -->
                                <!-- ko if: birthdayBeingEdited -->
                                    <div class="clearfix">
                                        <div class="w-90 float-l margin-r10">
                                            <div class="chzn-gray">
                                                <select data-bind="options: days, value: dayValue, chosen: {}" data-placeholder="день"></select>
                                            </div>
                                        </div>
                                        <div class="w-100 float-l margin-r10">
                                            <div class="chzn-gray">
                                                <select class="chzn" data-bind="options: monthes, optionsText: 'name', optionsValue: 'id', value: monthValue, chosen: {}" data-placeholder="месяц"></select>
                                            </div>
                                        </div>
                                        <div class="w-90 float-l">
                                            <div class="chzn-gray">
                                                <select class="chzn" data-bind="options: years, value: yearValue, chosen: {}" data-placeholder="год"></select>
                                            </div>
                                        </div>
                                        <button class="btn-green btn-small margin-l10" data-bind="click: saveBirthday">Ok</button>
                                        <!-- ko if: birthdayError() !== null -->
                                            <div class="errorMessage" data-bind="text: birthdayError"></div>
                                        <!-- /ko -->
                                    </div>
                                <!-- /ko -->
                            </div>
                        </div>
                    <!-- /ko -->
                    <!-- ko if: noticeIsEditable -->
                        <div class="form-settings_label-row">
                            <span data-bind="text: noticeLabel()"></span>
                            <!-- ko if: $parent.canEdit && ! noticeBeingEdited() && notice().length > 0 -->
                            <a class="a-pseudo-icon powertip" title="Редактировать" data-bind="click: editNotice">
                                <span class="ico-edit"></span>
                            </a>
                            <!-- /ko -->
                        </div>
                        <!-- ko if: ! noticeBeingEdited() -->
                            <!-- ko if: notice().length > 0 -->
                                <div class="family-settings_about clearfix" data-bind="text: notice"></div>
                            <!-- /ko -->
                            <!-- ko if: notice().length == 0 -->
                                <div class="family-settings_about clearfix"><a class="a-pseudo-gray" data-bind="text: noticePlaceholderLabel(), click: editNotice"></a></div>
                            <!-- /ko -->
                        <!-- /ko -->
                        <!-- ko if: noticeBeingEdited -->
                            <div class="family-settings_about clearfix">
                                <div class="w-300">
                                    <textarea cols="30" rows="4" class="itx-gray" data-bind="value: noticeValue, attr: { placeholder : noticePlaceholderLabel() }"></textarea>
                                    <div class="clearfix margin-t5">
                                        <button class="btn-green  btn-small margin-r5" data-bind="click: saveNotice">Сохранить</button>
                                        <a class="btn-gray-light  btn-small" data-bind="click: cancelEditNotice">Отменить</a>
                                    </div>
                                </div>
                            </div>
                        <!-- /ko -->
                    <!-- /ko -->
                </div>
            </div>
        </div>
        <!-- ko if: photosAreEditable -->
            <div class="photo-preview-row photo-preview-row__add clearfix">
                <h3 class="heading-small margin-b10" data-bind="text: photosLabel()"></h3>
                <div class="photo-preview-row_hold">
                    <div class="photo-grid clearfix">
                        <!-- ko foreach: photos -->
                            <div class="photo-grid_i" data-bind="click: open">
                                <img alt="" class="photo-grid_img" data-bind="attr: { src : smallThumbSrc }">
                                <div class="photo-grid_overlay">
                                    <span class="photo-grid_zoom"></span>
                                    <!-- ko if: $parents[1].canEdit -->
                                    <div class="photo-grid_overlay-row">
                                        <label for="photo-grid_check1" class="photo-grid_checbox-label" data-bind="tooltip: 'Сделать основным'">
                                            <input type="checkbox" class="photo-grid_checkbox" data-bind="checked: isMain, click: function() { return true; }, clickBubble: false">
                                        </label>
                                        <div class="float-r">
                                            <a href="" class="ico-del ico-del__white" data-bind="click: remove, clickBubble: false, tooltip: 'Удалить'"></a>
                                        </div>
                                    </div>
                                    <!-- /ko -->
                                </div>
                            </div>
                        <!-- /ko -->
                        <!-- ko if: $parent.canEdit -->
                        <span class="photo-preview-row_add file-fake">
                            <input type="file" name="photo" data-bind="fileupload: { url : PHOTO_UPLOAD_URL, formData : photoFormData(), callback : $parent.photoUploadCallback }">
                        </span>
                        <!-- /ko -->
                    </div>
                </div>
            </div>
        <!-- /ko -->
    </div>
</script>

<script type="text/html" id="member-small-template">
    <!-- ko if: ! isRemoved() -->
        <li class="b-family_li">
            <div class="b-family_img-hold">
                <!-- ko if: photoToShow() !== null -->
                    <img alt="" class="b-family_img" data-bind="attr: { src : photoToShow().bigThumbSrc }">
                <!-- /ko -->
                <!-- ko if: photoToShow() === null -->
                    <div class="ico-family" data-bind="css: cssClass()"></div>
                <!-- /ko -->
            </div>
            <div class="b-family_tx">
                <span data-bind="text: title()">Я</span>
                <!-- ko if: name().length > 0 -->
                <br><span data-bind="text: name"></span>
                <!-- /ko -->
                <!-- ko if: $data.type === null && $data.birthday !== null -->
                <br><span data-bind="text: age"></span>
                <!-- /ko -->
            </div>
        </li>
    <!-- /ko -->
</script>

<?php $this->renderPartial('_add_element'); ?>
