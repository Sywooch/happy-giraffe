<?php
/**
 * @var $this InterestsWidget
 */
?>
<div class="b-interest" id="user-interests" data-bind="css: {'b-interest__addition': adding()}">
    <h3 class="heading-small margin-b10">Мои интересы <!-- ko if: !adding() --><span class="color-gray">(<!--ko text: interests().length--><!--/ko-->)</span><!-- /ko -->
        <!-- ko if: adding() -->
        <div class="float-r color-gray font-small margin-t5">Добавлено <!--ko text: interests().length--><!--/ko--> из 25</div>
        <!-- /ko -->
    </h3>
    <!-- ko if: interests().length == 0 -->
    <span class="color-gray">У вас пока нет интересов</span>
    <!-- /ko -->

    <!-- ko if: !adding() -->
    <ul class="clearfix">
        <!-- ko foreach: interests -->
        <li class="b-interest_li">
            <a href="javascript:;" class="b-interest_i" data-bind="text: title, css: {active: have()}"></a>

            <div class="b-interest_popup">
                <div class="margin-b5 clearfix">
                    <!-- ko foreach: users -->
                    <a class="ava small" href="" data-bind="attr: {href: url}, css: avatarClass()">
                        <img src="" alt="" data-bind="attr: {src: ava}">
                    </a>
                    <!-- /ko -->
                </div>
                <div class="clearfix">
                    <!-- ko if: count() > 0 -->
                    <a href="javascript:;">и еще <!--ko text: count--><!--/ko--></a>
                    <!-- /ko -->

                    <?php if (!Yii::app()->user->isGuest):?>
                        <!-- ko if: !have() -->
                        <a href="" class="btn-green btn-small margin-l20" data-bind="click: toggle">Добавить мне</a>
                        <!-- /ko -->

                        <!-- ko if: have() -->
                        <a href="" class="btn-green btn-small margin-l20" data-bind="click: toggle">Убрать</a>
                        <!-- /ko -->
                    <?php endif ?>

                </div>
            </div>
        </li>
        <!-- /ko -->
    </ul>
    <?php if ($this->isMyProfile):?>
        <a href="" class="b-interest_add" data-bind="click: function (data) {data.adding(true)}"></a>
    <?php endif ?>
    <!-- /ko -->

    <?php if ($this->isMyProfile):?>
        <!-- ko if: adding() -->
        <ul class="b-interest_ul clearfix">
            <!-- ko if:  -->
            <li class="b-interest_li">
                <span class="color-gray">Выберите категорию и добавьте интерес просто кликнув по ему,  или </span>
            </li>
            <!-- /ko -->


            <li class="b-interest_li">
                <a href="" class="b-interest_i b-interest_i__green">Добавить свой интерес <span class="ico-plus margin-l3"></span> </a>
            </li>
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
            <!-- ko if: hasMore() -->
            <a href="" class="a-pseudo" data-bind="click: more">Показать еще 50</a>
            <!-- /ko -->
        </div>
        </div>
        <div class="clearfix">
            <a href="" class="btn-blue btn-medium float-r" data-bind="click: function (data) {data.adding(false)}">Готово</a>
        </div>
        </div>
        <!-- /ko -->
    <?php endif ?>
</div>
<script type="text/javascript">
    $(function () {
        vm = new UserInterestsWidget(<?=CJSON::encode($this->data)?>);
        ko.applyBindings(vm, document.getElementById('user-interests'));

        $('.b-interest_li').bind({
            mouseover: function () {
                $(this).find('.b-interest_popup').stop(true, true).fadeIn(200);
            },
            mouseout: function () {
                $(this).find('.b-interest_popup').stop(true, true).delay(200).fadeOut(200);
            }
        });
    });
</script>

<script type="text/html" id="user-interest-template">
    <li class="b-interest_li">
        <a href="javascript:;" class="b-interest_i" data-bind="text: title, css: {active: have()}"></a>

        <div class="b-interest_popup">
            <div class="margin-b5 clearfix">
                <!-- ko foreach: users -->
                <a class="ava small" href="" data-bind="attr: {href: url}, css: avatarClass()">
                    <img src="" alt="" data-bind="attr: {src: ava}">
                </a>
                <!-- /ko -->
            </div>
            <div class="clearfix">
                <!-- ko if: count() > 0 -->
                <a href="javascript:;">и еще <!--ko text: count--><!--/ko--></a>
                <!-- /ko -->

                    <?php if (!Yii::app()->user->isGuest):?>
                        <!-- ko if: !have() -->
                <a href="" class="btn-green btn-small margin-l20" data-bind="click: toggle">Добавить мне</a>
                <!-- /ko -->

                <!-- ko if: have() -->
                <a href="" class="btn-green btn-small margin-l20" data-bind="click: toggle">Убрать</a>
                <!-- /ko -->
                    <?php endif ?>

                </div>
        </div>
    </li>
</script>