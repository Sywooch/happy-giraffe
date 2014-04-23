<?php
/**
 * @var $json
 * @var string $nextUrl
 */

Yii::app()->clientScript
    ->registerPackage('ko_family')
;
?>

<a href="#reg-step4" class="reg-step4 display-n">Регистрация шаг 1</a>
<!-- .popup-sign-->
<script>
    $(function() {
        $('.reg-step4').magnificPopup({
            type: 'inline',
            overflowY: 'auto',
            closeOnBgClick: false,
            showCloseBtn: false,
            fixedBgPos: true,

            // When elemened is focused, some mobile browsers in some cases zoom in
            // It looks not nice, so we disable it:
            callbacks: {
                open: function() {
                    $('html').addClass('mfp-html html__reg-step4');
                }
            }
        });
        $('.reg-step4').magnificPopup('open');
    });
</script>
<div id="reg-step4" class="popup popup-sign popup-sign__reg-step3">
<div class="popup-sign_hold">
<div class="popup-sign_top">
    <div class="popup-sign_t"><?=Yii::app()->user->model->first_name?>, расскажите о вашей семье</div>
    <div class="popup-sign_slogan">Укажите состав вашей семьи и мы будем стараться формировать материал именно для вас</div>
</div>
<div class="b-family-structure clearfix">
<div class="b-family-structure_upload">
    <div class="b-family-structure_note">Все просто. Перетащите в пустые квадраты<br>членов вашей семьи</div>
    <div class="b-family b-family__bg-none">
        <ul class="b-family_ul">
            <li class="b-family_li" data-bind="draggable: partnerModels[0], template: { name : 'fake-element-template', data : partnerModels[0] }"></li>
            <li class="b-family_li" data-bind="draggable: partnerModels[1], template: { name : 'fake-element-template', data : partnerModels[1] }"></li>
            <li class="b-family_li" data-bind="draggable: partnerModels[2], template: { name : 'fake-element-template', data : partnerModels[2] }"></li>
        </ul>
    </div>
    <div class="b-family b-family__bg-none">
        <ul class="b-family_ul">
            <li class="b-family_li" data-bind="draggable: childrenModels[0], template: { name : 'fake-element-template', data : childrenModels[0] }"></li>
            <li class="b-family_li" data-bind="draggable: childrenModels[1], template: { name : 'fake-element-template', data : childrenModels[1] }"></li>
            <li class="b-family_li" data-bind="draggable: childrenModels[2], template: { name : 'fake-element-template', data : childrenModels[2] }"></li>
            <li class="b-family_li" data-bind="draggable: childrenModels[3], template: { name : 'fake-element-template', data : childrenModels[3] }"></li>
            <li class="b-family_li" data-bind="draggable: childrenModels[4], template: { name : 'fake-element-template', data : childrenModels[4] }"></li>
        </ul>
    </div>
    <div class="clearfix">
        <div class="float-l margin-r20 w-130 textalign-c">
            <div class="b-family_sub-t">Дети от 0 до 1 года</div>
            <div class="b-family b-family__bg-none">
                <ul class="b-family_ul">
                    <li class="b-family_li" data-bind="draggable: childrenModels[5], template: { name : 'fake-element-template', data : childrenModels[5] }"></li>
                    <li class="b-family_li" data-bind="draggable: childrenModels[6], template: { name : 'fake-element-template', data : childrenModels[6] }"></li>
                </ul>
            </div>
        </div>
        <div class="float-l margin-r20 w-130 textalign-c">
            <div class="b-family_sub-t"> Дети от 1 до 3 лет</div>
            <div class="b-family b-family__bg-none">
                <ul class="b-family_ul">
                    <li class="b-family_li" data-bind="draggable: childrenModels[7], template: { name : 'fake-element-template', data : childrenModels[7] }"></li>
                    <li class="b-family_li" data-bind="draggable: childrenModels[8], template: { name : 'fake-element-template', data : childrenModels[8] }"></li>
                </ul>
            </div>
        </div>
        <div class="float-l margin-r20 w-130 textalign-c">
            <div class="b-family_sub-t"> Дети от 3 до 6 лет</div>
            <div class="b-family b-family__bg-none">
                <ul class="b-family_ul">
                    <li class="b-family_li" data-bind="draggable: childrenModels[9], template: { name : 'fake-element-template', data : childrenModels[9] }"></li>
                    <li class="b-family_li" data-bind="draggable: childrenModels[10], template: { name : 'fake-element-template', data : childrenModels[10] }"></li>
                </ul>
            </div>
        </div>
        <div class="float-l margin-r20 w-130 textalign-c">
            <div class="b-family_sub-t">Дети от 6 до 12 лет</div>
            <div class="b-family b-family__bg-none">
                <ul class="b-family_ul">
                    <li class="b-family_li" data-bind="draggable: childrenModels[11], template: { name : 'fake-element-template', data : childrenModels[11] }"></li>
                    <li class="b-family_li" data-bind="draggable: childrenModels[12], template: { name : 'fake-element-template', data : childrenModels[12] }"></li>
                </ul>
            </div>
        </div>
        <div class="float-l margin-r20 w-130 textalign-c">
            <div class="b-family_sub-t">Дети от 12 до 18 лет</div>
            <div class="b-family b-family__bg-none">
                <ul class="b-family_ul">
                    <li class="b-family_li" data-bind="draggable: childrenModels[13], template: { name : 'fake-element-template', data : childrenModels[13] }"></li>
                    <li class="b-family_li" data-bind="draggable: childrenModels[14], template: { name : 'fake-element-template', data : childrenModels[14] }"></li>
                </ul>
            </div>
        </div>
        <div class="float-l margin-r20 w-130 textalign-c">
            <div class="b-family_sub-t">Старше 18 лет</div>
            <div class="b-family b-family__bg-none">
                <ul class="b-family_ul">
                    <li class="b-family_li" data-bind="draggable: childrenModels[15], template: { name : 'fake-element-template', data : childrenModels[15] }"></li>
                    <li class="b-family_li" data-bind="draggable: childrenModels[16], template: { name : 'fake-element-template', data : childrenModels[16] }"></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--Правая часть
-->
<div class="b-family-structure_added">
    <div class="b-family b-family__square">
        <div class="b-family_top b-family_top__white-big"></div>
        <!--Когда 9 ячеек не хватает для семьи, появляется еще ряд из 3 ячеек.
        -->
        <ul class="b-family_ul">
            <li class="b-family_li" data-bind="with: me">
                <div class="b-family_img-hold">
                    <div class="ico-family" data-bind="css: cssClass()"></div>
                </div>
                <div class="b-family_tx"><span>Я</span></div>
            </li>
            <!-- ko foreach: family -->
            <li class="b-family_li" data-bind="droppable: $root.drop, css: { 'b-family_li__empty' : isEmpty }, template: { name : 'element-template', if: ! isEmpty() }"></li>
            <!-- /ko -->
        </ul>
    </div>
    <div class="textalign-r color-white">
        Членов семьи: <span data-bind="text: familyMembersCount">5</span>
    </div>
</div>
</div>
</div>
<div class="popup-sign_b margin-t20 clearfix">
    <div class="float-r"><a class="btn-green-simple btn-l" data-bind="click: save">Готово</a></div>
    <div class="float-l margin-t12"><a class="color-gray" href="<?=$nextUrl?>">Пропустить этот шаг</a></div>
</div>
</div>
<!-- /popup-sign-->

<?php $this->renderPartial('family.views.default._add_element'); ?>

<script type="text/javascript">
    $(function() {
        familyVM = new FamilyViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(familyVM);
    });
</script>