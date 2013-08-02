<?php
/**
 * @var $this InterestsWidget
 */
?>
<div class="b-interest" id="user-interests">
    <h3 class="heading-small margin-b10">Мои интересы <span class="color-gray">(<!--ko text: interests().length--><!--/ko-->)</span>
    </h3>
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