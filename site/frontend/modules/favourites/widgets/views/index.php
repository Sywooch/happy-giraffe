<?php
/**
 * @var string $id
 * @var $data
 */
?>

<div class="favorites-control" id="<?=$id?>">
    <a href="javascript:void(0)" class="favorites-control_a powertip" data-bind="text: count, css: { active : active }, tooltip: active() ? 'Удалить из избранного' : 'В избранное', click: clickHandler">

    </a>

    <!-- ko if: adding -->
    <div class="favorites-add-popup" data-bind="with: adding">
        <div class="favorites-add-popup_t">Добавить запись в избранное</div>
        <div class="favorites-add-popup_i clearfix">
            <img class="favorites-add-popup_i-img" data-bind="attr: { src : image, alt: title }">
            <div class="favorites-add-popup_i-hold" data-bind="text: title"></div>
        </div>
        <div class="favorites-add-popup_row">
            <label for="" class="favorites-add-popup_label">Теги:
                <!-- ko foreach: tags -->
                <span class="favorites-add-popup_tag">
                    <a href="" class="favorites-add-popup_tag-a" data-bind="text: $data"></a>
                    <a href="javascript:void(0)" class="ico-close" data-bind="click: $parent.removeTag"></a>
                </span>
                <!-- /ko -->
        </div>
        <div class="favorites-add-popup_row margin-b10" data-bind="visible: ! tagsFormVisible(), click: showTagsForm">
            <a class="textdec-none" href="">
                <span class="ico-plus2 margin-r5"></span>
                <span class="a-pseudo-gray color-gray">Добавить</span>
            </a>
        </div>
        <div class="favorites-add-popup_row margin-b10" data-bind="visible: tagsFormVisible">
            <input type="text" class="favorites-add-popup_itx-tag ui-autocomplete-input" placeholder="Вводите теги через запятую или Enter" data-bind="value: tagsInputValue, valueUpdate: 'keyup', event: { keypress : tagHandler }">
        </div>
        <div class="favorites-add-popup_row">
            <label for="" class="favorites-add-popup_label">Комментарий</label>
            <div class="float-r color-gray" data-bind="text: note().length + '/150'"></div>
        </div>
        <div class="favorites-add-popup_row">
            <textarea name="" id="" cols="25" rows="2" class="favorites-add-popup_textarea" placeholder="Введите комментарий" data-bind="value: note, valueUpdate: 'keyup'" maxlength="150"></textarea>
        </div>
        <div class="favorites-add-popup_row textalign-c margin-t15">
            <a href="javascript:void(0)" class="btn-gray-light" data-bind="click: $root.cancel">Отменить</a>
            <a href="javascript:void(0)" class="btn-green" data-bind="click: $root.add">Добавить</a>
        </div>
    </div>
    <!-- /ko -->
</div>

<script type="text/javascript">
    ko.applyBindings(new FavouriteWidget(<?=CJSON::encode($data)?>), document.getElementById('<?=$id?>'));
</script>