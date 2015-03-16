<?php
Yii::app()->clientScript
    ->registerPackage('ko_family')
;
Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?>

<div class="b-registration">
    <div class="b-registration_row clearfix">
        <div class="float-r">
            <a class="b-registration_skip" data-bind="click: save">Пропустить этот шаг</a>
            <a class="btn-green btn-h46" data-bind="click: save">Готово, продолжить</a>
        </div>
        <div class="b-registration_t"><?=Yii::app()->user->model->first_name?>, расскажите о вашей семье</div>
    </div>

    <div class="content-cols">
        <div class="col-white padding-20">

            <div class="b-family-structure clearfix">
                <div class="b-family-structure_added">
                    <div class="b-family b-family__square">
                        <div class="b-family_top b-family_top__blue-big"></div>
                        <ul class="b-family_ul">
                            <li class="b-family_li" data-bind="with: me">
                                <div class="b-family_img-hold">
                                    <div class="ico-family" data-bind="css: cssClass()"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Я</span>
                                </div>
                            </li>
                            <!-- ko foreach: family -->
                                <li class="b-family_li" data-bind="droppable: $root.drop, css: { 'b-family_li__empty' : isEmpty }, template: { name : 'fake-element-template', if: ! isEmpty() }"></li>
                            <!-- /ko -->
                        </ul>
                    </div>
                    <div class="textalign-c font-big">
                        <!-- Для удобства число можно положить в span или другой строчный тег -->
                        Членов семьи: <span data-bind="text: familyMembersCount"></span>
                    </div>
                </div>

                <div class="b-family-structure_upload">
                    <div class="textalign-c margin-b40 font-big">Перетащите в пустые квадраты  членов вашей семьи</div>

                    <div class="b-family b-family__bg-none margin-b10">
                        <ul class="b-family_ul">
                        <!-- Объект для перетаскивания .b-family_li -->
                            <li class="b-family_li" data-bind="draggable: partnerModels[0], template: { name : 'fake-element-template', data : partnerModels[0] }"></li>
                            <li class="b-family_li" data-bind="draggable: partnerModels[1], template: { name : 'fake-element-template', data : partnerModels[1] }"></li>
                            <li class="b-family_li" data-bind="draggable: partnerModels[2], template: { name : 'fake-element-template', data : partnerModels[2] }"></li>
                        </ul>
                    </div>

                    <div class="b-family b-family__bg-none margin-b10">
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
                            <div class="color-gray font-small">Дети от 0 до 1 года</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li" data-bind="draggable: childrenModels[5], template: { name : 'fake-element-template', data : childrenModels[5] }"></li>
                                    <li class="b-family_li" data-bind="draggable: childrenModels[6], template: { name : 'fake-element-template', data : childrenModels[6] }"></li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 1 до 3 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li" data-bind="draggable: childrenModels[7], template: { name : 'fake-element-template', data : childrenModels[7] }"></li>
                                    <li class="b-family_li" data-bind="draggable: childrenModels[8], template: { name : 'fake-element-template', data : childrenModels[8] }"></li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 3 до 6 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li" data-bind="draggable: childrenModels[9], template: { name : 'fake-element-template', data : childrenModels[9] }"></li>
                                    <li class="b-family_li" data-bind="draggable: childrenModels[10], template: { name : 'fake-element-template', data : childrenModels[10] }"></li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 6 до 12 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li" data-bind="draggable: childrenModels[11], template: { name : 'fake-element-template', data : childrenModels[11] }"></li>
                                    <li class="b-family_li" data-bind="draggable: childrenModels[12], template: { name : 'fake-element-template', data : childrenModels[12] }"></li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 12 до 18 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li" data-bind="draggable: childrenModels[13], template: { name : 'fake-element-template', data : childrenModels[13] }"></li>
                                    <li class="b-family_li" data-bind="draggable: childrenModels[14], template: { name : 'fake-element-template', data : childrenModels[14] }"></li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Старше 18 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li" data-bind="draggable: childrenModels[15], template: { name : 'fake-element-template', data : childrenModels[15] }"></li>
                                    <li class="b-family_li" data-bind="draggable: childrenModels[16], template: { name : 'fake-element-template', data : childrenModels[16] }"></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="b-registration_row clearfix">
        <div class="float-r">
            <a class="b-registration_skip" data-bind="click: save">Пропустить этот шаг</a>
            <a class="btn-green btn-h46" data-bind="click: save">Готово, продолжить</a>
        </div>
    </div>
</div>

<?php $this->renderPartial('_add_element'); ?>

<script type="text/javascript">
    $(function() {
        familyVM = new FamilyViewModel(<?=CJSON::encode($json)?>);
        ko.applyBindings(familyVM);
    });
</script>