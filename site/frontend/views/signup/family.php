<?php
    Yii::app()->clientScript
        ->registerPackage('ko_family')
    ;
?>

<div class="b-registration">
    <div class="b-registration_row clearfix">
        <div class="float-r">
            <a href="" class="b-registration_skip">Пропустить этот шаг</a>
            <a href="" class="btn-green btn-h46">Готово, продолжить</a>
        </div>
        <div class="b-registration_t">Александра, расскажите о вашей семье</div>
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
                                    <div class="ico-family" data-bind="css: cssClass"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Я</span>
                                </div>
                            </li>
                            <!-- ko foreach: family -->
                                <li class="b-family_li b-family_li__empty" data-bind="drop: $root.drop"></li>
                            <!-- /ko -->
                        </ul>
                    </div>
                    <div class="textalign-c font-big">
                        <!-- Для удобства число можно положить в span или другой строчный тег -->
                        Членов семьи: 5
                    </div>
                </div>

                <div class="b-family-structure_upload">
                    <div class="textalign-c margin-b40 font-big">Все просто. Перетащите в пустые квадраты <br>членов вашей семьи</div>

                    <div class="b-family b-family__bg-none margin-b10">
                        <ul class="b-family_ul">
                        <!-- Объект для перетаскивания .b-family_li -->
                            <li class="b-family_li" data-bind="drag: drag">
                                <div class="b-family_img-hold">
                                    <div class="ico-family ico-family__husband"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Муж</span>
                                </div>
                            </li>
                            <li class="b-family_li" data-bind="drag: drag">
                                <div class="b-family_img-hold">
                                    <div class="ico-family ico-family__fiance"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Жених</span>
                                </div>
                            </li>
                            <li class="b-family_li" data-bind="drag: drag">
                                <div class="b-family_img-hold">
                                    <div class="ico-family ico-family__boy-friend"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Друг</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="b-family b-family__bg-none margin-b10">
                        <ul class="b-family_ul">
                            <li class="b-family_li">
                                <div class="b-family_img-hold">
                                    <div class="ico-family ico-family__boy-wait"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Ждем мальчика</span>
                                </div>
                            </li>
                            <li class="b-family_li">
                                <div class="b-family_img-hold">
                                    <div class="ico-family ico-family__girl-wait"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Ждем девочку</span>
                                </div>
                            </li>
                            <li class="b-family_li">
                                <div class="b-family_img-hold">
                                    <div class="ico-family ico-family__baby"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Ждем ребенка</span>
                                </div>
                            </li>
                            <li class="b-family_li">
                                <div class="b-family_img-hold">
                                    <div class="ico-family ico-family__baby-two"></div>
                                </div>
                                <div class="b-family_tx">
                                    <span>Ждем двойню</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="clearfix">
                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 0 до 1 года</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__girl-small"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Дочь</span>
                                        </div>
                                    </li>
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__boy-small"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Сын</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 1 до 3 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__girl-3"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Дочь</span>
                                        </div>
                                    </li>
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__boy-3"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Сын</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 3 до 6 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__girl-5"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Дочь</span>
                                        </div>
                                    </li>
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__boy-5"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Сын</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 6 до 12 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__girl-8"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Дочь</span>
                                        </div>
                                    </li>
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__boy-8"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Сын</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Дети от 12 до 18 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__girl-14"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Дочь</span>
                                        </div>
                                    </li>
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__boy-14"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Сын</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="float-l margin-r20 w-130 textalign-c">
                            <div class="color-gray font-small">Старше 18 лет</div>
                            <div class="b-family b-family__bg-none margin-b10">
                                <ul class="b-family_ul">
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__girl-19"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Дочь</span>
                                        </div>
                                    </li>
                                    <li class="b-family_li">
                                        <div class="b-family_img-hold">
                                            <div class="ico-family ico-family__boy-19"></div>
                                        </div>
                                        <div class="b-family_tx">
                                            <span>Сын</span>
                                        </div>
                                    </li>
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
            <a href="" class="b-registration_skip">Пропустить этот шаг</a>
            <a href="" class="btn-green btn-h46">Готово, продолжить</a>
        </div>
    </div>
</div>

<script type="text/javascript">
    familyVM = new FamilyViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(familyVM);
</script>