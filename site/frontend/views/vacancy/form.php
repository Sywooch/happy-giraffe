<?php
/**
 * @var SiteController $this
 * @var ClientScript $cs
 * @var CActiveForm $form
 * @var VacancyForm $model
 * @var string $type
 */
$cs = Yii::app()->clientScript;
$cs->registerPackage('vacancy');
$this->bodyClass = 'body__vacancy';
?>

<?=CHtml::cssFile('/stylesheets/vacancy.css?r=' . $cs->getReleaseId())?>

<div class="layout-container">
    <div class="layout-wrapper">

        <div class="vacancy clearfix">
            <div class="vacancy_header clearfix">
                <a href="<?=$this->createUrl('site/index')?>">
                    <div class="vacancy_logo"></div>
                </a>
                <div class="vacancy_header-tx">Мы - социальная сеть для всей семьи. Стартовав в 2012 году, мы входим в ТОП-3 <br> крупнейших семейных сайтов Рунета, с посещаемостью <span class="vacancy_header-highlight">&nbsp;более <span class="vacancy_header-big">5 000 000</span> пап и мам </span>&nbsp; в месяц.</div>
            </div>

            <?php $this->renderPartial('_' . $type); ?>

            <div class="vacancy_send display-n">
                <h2 class="vacancy_about-t">Спасибо за ваш интерес!</h2>
                <div class="vacancy_send-tx">Мы с вами свяжемся в ближайшее время.</div>
                <div class="vacancy_help">
                    <span class="color-gray">Вы можете написать нам &nbsp;</span>
                    <a href="mailto:info@happy-giraffe.ru">info@happy-giraffe.ru</a>
                </div>
            </div>

            <div class="f-about">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'vacancyForm',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate' => 'js:afterValidateVacancy',
                        'beforeValidate' => 'js:beforeValidateVacancy',
                        'inputContainer' => 'div.inp-valid',
                    ),
                )); ?>
                <div class="f-about_row clearfix">
                    <div class="f-about_col-l">
                    </div>
                    <div class="f-about_col-r">
                        <h2 class="vacancy_about-t">Расскажи о себе</h2>
                    </div>
                </div>
                <div class="f-about_row clearfix">
                    <div class="f-about_col-l">
                        <?=$form->label($model, 'fullName', array('class' => 'f-about_label'))?>
                    </div>
                    <div class="f-about_col-r">
                        <div class="inp-valid inp-valid__abs">
                            <?=$form->textField($model, 'fullName', array('class' => 'itx-gray'))?>
                            <div class="inp-valid_error">
                                <?=$form->error($model, 'fullName'); ?>
                            </div>
                            <div class="inp-valid_success inp-valid_success__ico-check"></div>
                        </div>
                    </div>
                </div>
                <div class="f-about_row clearfix">
                    <div class="f-about_col-l">
                        <?=$form->label($model, 'email', array('class' => 'f-about_label'))?>
                    </div>
                    <div class="f-about_col-r">

                        <div class="inp-valid inp-valid__abs">
                            <?=$form->textField($model, 'email', array('class' => 'itx-gray'))?>
                            <div class="inp-valid_error">
                                <?=$form->error($model, 'email'); ?>
                            </div>
                            <div class="inp-valid_success inp-valid_success__ico-check"></div>
                        </div>
                    </div>
                </div>
                <div class="f-about_row margin-b70 clearfix">
                    <div class="f-about_col-l">
                        <?=$form->label($model, 'phoneNumber', array('class' => 'f-about_label'))?>
                    </div>
                    <div class="f-about_col-r">

                        <div class="inp-valid inp-valid__abs">
                            <?=$form->textField($model, 'phoneNumber', array('class' => 'itx-gray'))?>
                            <div class="inp-valid_error">
                                <?=$form->error($model, 'phoneNumber'); ?>
                            </div>
                            <div class="inp-valid_success inp-valid_success__ico-check"></div>
                        </div>
                    </div>
                </div>
                <div class="f-about_row clearfix">
                    <label class="f-about_label">
                        Уже есть готовое резюме (
                        <span class="vacancy_ico-doc"></span>
                        <span class="vacancy_ico-pdf"></span>
                        )

                    </label>
                    <div class="file-fake">
                        <input type="file" class="file-fake_inp" name="cv">
                        <div class="btn-blue-simple file-fake_btn">Прикрепить </div>
                    </div>
                    <!-- ko with: cv() -->
                    <div class="f-about_upload">
                        <span data-bind="text: name"></span>
                        <a href="" class="ico-close3" data-bind="click: $root.clearCv"></a>
                    </div>
                    <!-- /ko -->
                    <?=$form->hiddenField($model, 'cvUrl', array('class' => 'itx-gray', 'data-bind' => 'value: cvValue'))?>
                </div>
                <div class="f-about_or">или</div>
                <div class="f-about_row clearfix">
                    <div class="f-about_col-l">
                        <?=$form->label($model, 'hhUrl', array('class' => 'f-about_label'))?>
                    </div>
                    <div class="f-about_col-r">
                        <div class="inp-valid inp-valid__abs">
                            <?=$form->textField($model, 'hhUrl', array('class' => 'itx-gray'))?>
                            <div class="inp-valid_error">
                                <?=$form->error($model, 'hhUrl'); ?>
                            </div>
                            <div class="inp-valid_success inp-valid_success__ico-check"></div>
                        </div>
                    </div>
                </div>
                <div class="f-about_row clearfix">
                    <div class="f-about_col-l">
                    </div>
                    <div class="f-about_col-r">
                        <div class="margin-t15">
                            <button class="btn-green-simple btn-xxl">ОТПРАВИТЬ</button>
                        </div>
                        <div class="vacancy_help">
                            <span class="color-gray">Вы можете написать нам</span> <a href="mailto:info@happy-giraffe.ru">info@happy-giraffe.ru</a>
                        </div>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
            <div class="vacancy_footer">
                Другие вакансии компании:
                <?php if ($type == 'backend'): ?>
                    <?=CHtml::link('Frontend-разработчик', array('vacancy/form', 'type' => 'frontend'))?>
                <?php else: ?>
                    <?=CHtml::link('Backend-разработчик', array('vacancy/form', 'type' => 'backend'))?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    vacancyForm = new VacancyViewModel();
    ko.applyBindings(vacancyForm, document.getElementById('vacancyForm'));
</script>