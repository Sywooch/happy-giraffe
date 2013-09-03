<div id="register-step2" class="popup-sign">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'reg-form2',
    'action' => '#',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => '.display-ib.verticalalign-m, .float-l.w-50p',
        'validateOnSubmit' => true,
        'validateOnChange' => true,
        'validateOnType' => false,
        'validationUrl' => Yii::app()->createUrl('/signup/validate', array('step' => 2)),
        'afterValidate' => "js:function(form, data, hasError) {
                        if (!hasError){
                            Register.finish();
                        }
                        return false;
                      }",
    )));?>

    <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-830">

            <div class="b-settings-blue">
                <div class="b-sign">
                    <div class="b-sign_t">Вы уже почти с нами!</div>
                    <div class="textalign-c margin-b30">
                        <span class="i-highlight i-highlight__big font-big">Осталось ввести еще немного данных</span>
                    </div>
                    <div class="textalign-c margin-b40">
                        <div class="display-ib verticalalign-m">
                            <div class="b-sign_label-hold margin-r10">
                                <label for="" class="b-sign_label">Ваш e-mail</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <?=$form->textField($model, 'email', array('class' => 'itx-simple', 'placeholder' => 'Введите ваш e-mail'))?>
                                <?=$form->error($model, 'email')?>
                            </div>
                            <div class="float-l w-30">
                                <div class="b-sign_win"></div>
                            </div>
                        </div>
                    </div>
                    <div class="margin-b40 clearfix">
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Имя</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <?=$form->textField($model, 'first_name', array('class' => 'itx-simple', 'placeholder' => 'Введите имя'))?>
                                <?=$form->error($model, 'first_name')?>
                            </div>
                            <div class="b-sign_win"></div>
                        </div>
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Фамилия</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <?=$form->textField($model, 'last_name', array('class' => 'itx-simple', 'placeholder' => 'Введите фамилию'))?>
                                <?=$form->error($model, 'last_name')?>
                            </div>
                            <div class="b-sign_win"></div>
                        </div>
                    </div>
                    <div class="margin-b30 clearfix">
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Дата рождения</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <div class="clearfix">
                                    <div class="w-70 float-l margin-r5">
                                        <div class="chzn-itx-simple">
                                            <?=$form->dropDownList($model, 'day',  array_combine(range(1, 31), range(1, 31)), array('class' => 'chzn', 'data-placeholder' => 'день', 'empty' => ''))?>
                                        </div>
                                    </div>
                                    <div class="w-110 float-l margin-r5">
                                        <div class="chzn-itx-simple">
                                            <?=$form->dropDownList($model, 'month', array_combine(range(1, 12), array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря')), array('class' => 'chzn', 'data-placeholder' => 'месяц', 'empty' => ''))?>
                                        </div>
                                    </div>
                                    <div class="w-80 float-l">
                                        <div class="chzn-itx-simple">
                                            <?=$form->dropDownList($model, 'year', array_combine(range(1910, date("Y")), range(1910, date("Y"))), array('class' => 'chzn', 'data-placeholder' => 'год', 'empty' => ''))?>
                                        </div>
                                    </div>
                                </div>
                                <?=$form->hiddenField($model, 'birthday')?>
                                <?=$form->error($model, 'birthday')?>
                            </div>
                            <div class="b-sign_win"></div>
                        </div>
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Пол</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <div class="b-radio-icons">
                                    <?=$form->radioButtonList($model, 'gender', array('1' => '<span class="ico-male"></span>', '0' => '<span class="ico-female"></span>'), array('class' => 'b-radio-icons_radio', 'uncheckValue' => null, 'separator' => '', 'labelOptions' => array('class' => 'b-radio-icons_label')))?>
                                    <?=$form->error($model, 'gender')?>
                                    <div class="b-sign_win"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="b-sign_hr margin-b30"></div>


                    <div class="margin-b40 clearfix">
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Пароль</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <?=$form->passwordField($model, 'password', array('class' => 'itx-simple'))?>
                                <?=$form->error($model, 'password')?>
                                <div class="b-sign_itx-desc">Придумайте сложный пароль, от 6 до 12 символов - цифры и английские буквы.</div>
                            </div>
                            <div class="b-sign_win"></div>
                        </div>
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Пароль <br>еще раз</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <?=$form->passwordField($model, 'passwordRepeat', array('class' => 'itx-simple'))?>
                                <?=$form->error($model, 'passwordRepeat')?>
                            </div>
                            <div class="b-sign_win"></div>
                        </div>
                    </div>

                    <div class="b-sign_bottom">
                        <button class="btn-blue btn-h55 b-sign_btn-reg">Регистрация</button>
                    </div>
                </div>



            </div>

        </div>
    </div>

    <?php $this->endWidget(); ?>
</div>