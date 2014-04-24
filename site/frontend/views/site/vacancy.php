<?php
/**
 * @var SiteController $this
 * @var ClientScript $cs
 * @var CActiveForm $form
 * @var VacancyForm $model
 */
$cs = Yii::app()->clientScript;
$this->bodyClass = 'body__vacancy';
?>

<?=CHtml::cssFile('/stylesheets/vacancy.css?r=' . $cs->getReleaseId())?>
<div class="layout-container">
    <div class="layout-wrapper">

        <div class="vacancy clearfix">
            <div class="vacancy_header clearfix">
                <div class="vacancy_logo"></div>
                <div class="vacancy_header-tx">Мы - социальная сеть для всей семьи. Стартовав в 2012 году, мы входим в ТОП-3 <br> крупнейших семейных сайтов Рунета, с посещаемостью <span class="vacancy_header-highlight">&nbsp;более <span class="vacancy_header-big">5 000 000</span> пап и мам </span>&nbsp; в месяц.</div>
            </div>

            <div class="requirements clearfix">
                <h1 class="requirements_title">НАМ НУЖЕН WEB-РАЗРАБОТЧИК</h1>
                <div class="requirements_title-sub">В офис г. Ярославль - Петровский Пассаж </div>
                <div class="requirements_hold clearfix">
                    <div class="requirements_col-l">
                        <h3 class="requirements_t"> Умный<br>и адекватный</h3>
                        <div class="requirements_desc">Умение работать по техническому<br> заданию четко и быстро</div>
                        <h3 class="requirements_t">Ответственный</h3>
                        <div class="requirements_desc">Обучаемый и без заморочек<br> сделает работу в срок</div>
                        <div class="requirements_pay"></div>
                    </div>
                    <div class="requirements_col-r">
                        <h3 class="requirements_t">Увлеченный <br>и талантливый</h3>
                        <div class="requirements_desc">Главное - это умение быстро <br> и профессионально разрабатывать <br>Web-проекты любой сложности</div>
                        <h3 class="requirements_t">Умелый</h3>
                        <div class="requirements_desc">
                            <div class="margin-b15">Владеющий следующими навыками </div>
                            <div class="requirements_skils"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="vacancy_row vacancy_row__blue">
                <h3 class="vacancy_row-t">Что мы <br>предлагаем</h3>
                <div class="vacancy_row-desc">
                    <ul class="vacancy_ul">
                        <li class="vacancy_li">Работа в центре города в просторном офисе.</li>
                        <li class="vacancy_li">Мы стараемся использовать самые передовые и современные технологии - это прекрасная возможность для профессионального роста.</li>
                        <li class="vacancy_li">Общение с целым рядом экспертов в своих областях.</li>
                        <li class="vacancy_li">Каждый день можно разрабатывать новые и интересные задачи.  Это отличная возможность получать знания.</li>
                        <li class="vacancy_li">Мы развиваем свой продукт, поэтому выбираем долгосрочные решения.</li>
                        <li class="vacancy_li">Никакого перебрасывания с проекта на проект. Мы “готовим” один продукт, поэтому будет возможность обустроить свое рабочее место.</li>
                        <li class="vacancy_li">Достойную заработную плату (от  40 000 до 80 000 рублей)</li>
                    </ul>
                </div>
            </div>
            <div class="vacancy_row vacancy_row__green">
                <div class="vacancy_row-desc">
                    <ul class="vacancy_ul">
                        <li class="vacancy_li">Опыт работы с PHP от одного года.</li>
                        <li class="vacancy_li">Опыт работы с JavaScript от одного года (где-то я читал, что это можно проверить по количеству колец на срезе).</li>
                        <li class="vacancy_li">Желателен опыт работы с backbone.js, knockout.js или подобными (проект использует knockout.js).</li>
                        <li class="vacancy_li">Было бы классно, если было знакомство с yii.</li>
                        <li class="vacancy_li">Опыт работы с Comet-сервером или websocket.</li>
                        <li class="vacancy_li">Чтение книг Фаулера, Банды четырех, Джоэла Спольски (никто не умирал от дополнительных знаний).</li>
                        <li class="vacancy_li">Опыт работы в нагруженных проектах (перетаскивание шкафов и серверных стоек не в счет)...</li>
                    </ul>
                </div>
                <h3 class="vacancy_row-t">Приветствуется</h3>
            </div>
            <div class="vacancy_row vacancy_row__carrot">
                <h3 class="vacancy_row-t">Что нужно <br> будет	<br>делать</h3>
                <div class="vacancy_row-desc">
                    <ul class="vacancy_ul">
                        <li class="vacancy_li">Общаться с командой (без этого вообще нельзя делать продукт!).</li>
                        <li class="vacancy_li">Писать код (кстати, чем меньше кода для решения задачи напишите, тем лучше).</li>
                        <li class="vacancy_li">Высказывать свои идеи (мы не обладаем всеми знаниями, с удовольствием послушаем и внедрим).</li>
                        <li class="vacancy_li">Изучать новые технологии (расширение кругозора).</li>
                        <li class="vacancy_li">Работать в linux c обязательным использованием командной строки.</li>
                        <li class="vacancy_li">Работать в git.</li>
                    </ul>
                </div>
            </div>
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
                <div class="f-about_row clearfix">
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
        </div>

        <div class="footer-push"></div>
        <?php $this->renderPartial('//_footer'); ?>
    </div>
</div>

<script type="text/javascript">
function afterValidateVacancy(form, data, hasError) {
    if (! hasError) {
        $.post(form.attr('action'), form.serialize(), function(response) {
            if (response.success) {
                $('.vacancy_send').removeClass('display-n');
                $('.f-about').addClass('display-n');
            }
        }, 'json');
    }
    $(form).find('button').removeAttr('disabled');
    return false;
}

function beforeValidateVacancy(form) {
    $(form).find('button').attr('disabled', 'disabled');
    return true;
}
</script>