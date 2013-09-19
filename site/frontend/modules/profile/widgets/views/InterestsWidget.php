<?php
/**
 * @var $this InterestsWidget
 */
?>
<div class="b-interest" id="user-interests" data-bind="css: {'b-interest__addition': adding()}" style="display: none" data-bind="visible: true">
    <h3 class="heading-small margin-b10">Мои интересы
        <span class="color-gray" data-bind="visible:!adding()">(<!--ko text: interests().length-->  <!--/ko-->)</span>
        <div class="float-r color-gray font-small margin-t5" data-bind="visible: adding()">Добавлено <!--ko text: interests().length--><!--/ko--> из 25</div>
    </h3>
    <span class="color-gray float-l" data-bind="visible: interests().length == 0 && !adding()">У вас пока нет интересов</span>
    <?php if ($this->isMyProfile):?>
        <a href="" class="b-interest_add" data-bind="visible: interests().length == 0 && !adding(), click: function () {$data.adding(true)}"></a>
    <?php endif ?>

    <ul class="clearfix" data-bind="visible: !adding()">
        <!-- ko foreach: interests -->
        <li class="b-interest_li" data-bind="template: { name: 'user-interest-template', data: $data }"></li>
        <!-- /ko -->
        <?php if ($this->isMyProfile):?>
            <li class="b-interest_li" data-bind="visible: interests().length > 0">
                <a href="" class="b-interest_add" data-bind="click: function () {$data.adding(true)}"></a>
            </li>
        <?php endif ?>
    </ul>

    <?php if ($this->isMyProfile):?>
        <!-- ko if: adding() -->
        <ul class="b-interest_ul clearfix">
            <li class="b-interest_li" data-bind="visible: interests().length == 0">
                <span class="color-gray">Добавьте интерес, просто кликнув по нему, или </span>
            </li>

            <ul class="clearfix">
                <!-- ko foreach: interests -->
                <li class="b-interest_li" data-bind="template: { name: 'user-interest-template', data: $data }"></li>
                <!-- /ko -->
                <li class="b-interest_li" data-bind="visible: !_addingNew()">
                    <a href="javascript:;" class="b-interest_i b-interest_i__green" data-bind="click: addingNew">Добавить свой интерес <span class="ico-plus margin-l3"></span> </a>
                </li>
                <li class="b-interest_li" data-bind="visible: _addingNew()">
                    <div class="b-itx-add">
                        <input type="text" placeholder="Название" class="b-itx-add_itx" data-bind="value: newName">
                        <button class="ico-plus2" data-bind="click: addNew"></button>
                    </div>
                </li>
            </ul>

        </ul>

        <div class="b-interest_section">
            <div class="b-interest_section-hold clearfix">
                <div class="b-interest_categories">
                    <div class="b-interest_category-i">
                        <a href="" class="b-interest_category-a" data-bind="click: showAll">Все интересы</a>
                    </div>
                    <!-- ko foreach: categories -->
                    <div class="b-interest_category-i">
                        <a href="" class="b-interest_category-a" data-bind="text: title, click: select"></a>
                    </div>
                    <!-- /ko -->
                </div>
                <div class="b-interest_choice-col">
                    <ul class="b-interest_ul clearfix">
                        <!-- ko foreach: categoryInterests() -->
                        <li class="b-interest_li">
                            <a href="" class="b-interest_i b-interest_i__white" data-bind="text: title, click: add, css: {active: active()}"></a>
                        </li>
                        <!-- /ko -->
                    </ul>
                    <a href="" class="a-pseudo" data-bind="click: more, visible: hasMore()">Показать еще 50</a>
                </div>
            </div>
            <div class="clearfix">
                <a href="" class="btn-blue btn-medium float-r" data-bind="click: function (){$data.adding(false);$data._addingNew(false)}">Готово</a>
            </div>
        </div>
        <!-- /ko -->

    <?php endif ?>
</div>
<script type="text/html" id="user-interest-template">
    <a href="javascript:;" class="b-interest_i" data-bind="text: title, css: {active: isActive}, event: { mouseover: enableDetails}"></a>

    <div class="b-interest_popup">
        <div class="margin-b5 clearfix">
            <!-- ko foreach: users -->
            <a class="ava small" href="" data-bind="attr: {href: url}, css: avatarClass()">
                <img src="" data-bind="attr: {src: ava}">
            </a>
            <!-- /ko -->
        </div>
        <div class="clearfix">
            <span class="color-gray" data-bind="visible: count() > 6">и еще <!--ko text: (count() - 6) --><!--/ko--></span>

            <?php if (!Yii::app()->user->isGuest):?>
            <a href="" class="btn-green btn-small margin-l20" data-bind="click: toggle, visible: !active()">Добавить мне</a>
            <a href="" class="btn-green btn-small margin-l20" data-bind="click: toggle, visible: active()">Убрать</a>
            <?php endif ?>

        </div>
    </div>
</script>
<script type="text/javascript">
    $(function () {
        vm = new UserInterestsWidget(<?=CJSON::encode($this->data)?>);
        ko.applyBindings(vm, document.getElementById('user-interests'));
    });

    $('body').delegate('.b-interest_li', 'mouseenter', function(e){
        $(this).find('.b-interest_popup').stop(true, true).delay(200).fadeIn(200);
    }).delegate('.b-interest_li', 'mouseleave', function(e){
        $(this).find('.b-interest_popup').stop(true, true).delay(200).fadeOut(200);
    });
</script>
