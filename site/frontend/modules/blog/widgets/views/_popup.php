<!-- ko if: adding -->
<div class="favorites-add-popup<?php if ($this->right) echo ' favorites-add-popup__right' ?>" data-bind="with: adding">
    <div class="favorites-add-popup_t">Репост записи</div>
    <div class="favorites-add-popup_i clearfix">
        <img class="favorites-add-popup_i-img" data-bind="visible: image !== false, attr: { src : image, alt: title }">
        <div class="favorites-add-popup_i-hold" data-bind="text: title"></div>
    </div>
    <div class="favorites-add-popup_row">
        <label for="" class="favorites-add-popup_label">Комментарий:</label>
        <div class="float-r color-gray" data-bind="text: note().length + '/150'"></div>
    </div>
    <div class="favorites-add-popup_row">
        <textarea name="" id="" cols="25" rows="2" class="favorites-add-popup_textarea" placeholder="Введите комментарий" data-bind="value: note, valueUpdate: 'keyup'" maxlength="150"></textarea>
    </div>
    <div class="favorites-add-popup_row textalign-c margin-t15">
        <a href="" class="btn-gray-light" data-bind="click: $parent.cancel">Отменить</a>
        <a href="" class="btn-green" data-bind="click: $parent.add">Добавить</a>
    </div>
</div>
<!-- /ko -->