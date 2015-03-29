<?php
/**
 * @var \LiteController $this
 * @var \site\frontend\modules\consultation\models\forms\AskForm $model
 * @var \site\frontend\components\requirejsHelpers\ActiveForm $form
 */
$this->bodyClass = 'body__create';
$this->pageTitle = 'Задать вопрос';
?>


<div class="layout-loose_hold clearfix">
    <div class="b-main">
        <div class="b-main_cont b-main_cont__wide">
            <div class="postAdd b-main_col-hold clearfix"><a href="#" class="ico-close6">×</a>
                <?php $form = $this->beginWidget('site\frontend\components\requirejsHelpers\ActiveForm', array(
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                )); ?>
                <!-- основная колонка-->
                <div class="b-main_col-article b-consult-form b-consult-form__create">
                    <div class="postAdd_hold">
                        <div class="postAdd_row">
                            <div class="heading-xxl">
                                <div class="ico-post-type ico-post-type__article active"></div>Задать вопрос
                            </div>
                        </div>
                        <div class="postAdd_row">
                            <div class="inp-valid inp-valid__abs">
                                <?=$form->textField($model, 'title', array('placeholder' => 'Заголовок', 'class' => 'itx-gray'))?>
                                <?=$form->error($model, 'title', array('class' => 'inp-valid_error'))?>
                            </div>
                        </div>
                        <div class="postAdd_row">
                            <!-- wisywig-->
                            <script src="/lite/redactor/redactor.min.js"></script>
                            <script src="/lite/redactor/lang/ru.js"></script>
                            <!--script(src="#{path}redactor/plugins/fullscreen/fullscreen.js")-->
                            <script src="/lite/redactor/plugins/formatbtn/formatbtn.js"></script>
                            <script src="/lite/redactor/plugins/btnaddphoto/btnaddphoto.js"></script>
                            <script src="/lite/redactor/plugins/btnaddvideo/btnaddvideo.js"></script>
                            <script src="/lite/redactor/plugins/btnaddsmile/btnaddsmile.js"></script>
                            <script src="/lite/redactor/plugins/btnaddlink/btnaddlink.js"></script>
                            <script>
                                $(document).ready(function () {
                                    $('.wysiwyg-redactor').redactor({
                                        minHeight: 450,
                                        lang: 'ru',
                                        linkTooltip: false,

                                        plugins: ['formatbtn' ],
                                        buttons: ['']
                                    });
                                });
                            </script>
                            <div class="wysiwyg-post redactor_box">
                                <?=$form->textArea($model, 'text', array('colrow' => 9, 'class' => 'wysiwyg-redactor'))?>
                                <?=$form->error($model, 'text', array('class' => 'inp-valid_error'))?>
                            </div>
                        </div>
                    </div>
                    <!-- Строка кнопок-->
                    <!-- postAdd_btns-->
                    <div class="postAdd_row">
                        <div class="postAdd_count"> </div>
                        <div class="b-main_col-article clearfix">
                            <div class="postAdd_btns-hold"><a href="#" class="btn btn-secondary btn-xm margin-r15">Отменить</a><button class="btn btn-success btn-xm">Опубликовать</button>
                            </div>
                        </div>
                    </div>
                    <!-- /Строка кнопок-->
                </div>
                <?php $this->endWidget(); ?>
                <!-- /основная колонка -->
                <!-- сайдбар-->
                <div class="b-main_col-sidebar"></div>
                <!-- /сайдбар-->
            </div>
        </div>
    </div>
</div>