<div id="register-step2" class="popup-sign">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'reg-form2',
    'action' => '#',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
    'clientOptions' => array(
        'inputContainer' => '.row',
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
                                <!--<input type="text" name="" id="" class="itx-simple" placeholder="Введите ваш e-mail" value="rtyrtyr@er.ru">-->
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
                                <!--<input type="text" name="" id="" class="itx-simple" placeholder="Введите имя">-->
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
                                <!--<input type="text" name="" id="" class="itx-simple" placeholder="Введите фамилию">-->
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
                            <div class="b-sign_itx-hold error">
                                <div class="clearfix">
                                    <div class="w-70 float-l margin-r5">
                                        <div class="chzn-itx-simple">
                                            <select class="chzn"  data-placeholder="день">
                                                <option value=""></option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>32</option>
                                                <option>32</option>
                                                <option>32</option>
                                                <option>32</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-110 float-l margin-r5">
                                        <div class="chzn-itx-simple">
                                            <select class="chzn" data-placeholder="месяц">
                                                <option value=""></option>
                                                <option>Января</option>
                                                <option>Февраля</option>
                                                <option>Марта</option>
                                                <option>Апреля</option>
                                                <option>Майя</option>
                                                <option>Июня</option>
                                                <option>Июля</option>
                                                <option>Августа</option>
                                                <option>Сентября</option>
                                                <option>Октября</option>
                                                <option>Ноября</option>
                                                <option>Декабря</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="w-80 float-l">
                                        <div class="chzn-itx-simple">
                                            <select class="chzn" data-placeholder="год">
                                                <option value=""></option>
                                                <option>1912</option>
                                                <option>1913</option>
                                                <option>1914</option>
                                                <option>1915</option>
                                                <option>1916</option>
                                                <option>1988</option>
                                                <option>1999</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="errorMessage">Введите дату рождения</div>
                            </div>
                            <div class="b-sign_win"></div>
                        </div>
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Пол</label>
                            </div>
                            <div class="b-sign_itx-hold">
                                <div class="b-radio-icons">
                                    <!-- Данные для примера id="radio2" name="b-radio2" и for="radio2" -->
                                    <!--<input type="radio" name="b-radio2" id="radio2" class="b-radio-icons_radio" checked="">-->
                                    <?=$form->radioButton($model, 'gender', array('value' => '1', 'class' => 'b-radio-icons_radio', 'id' => 'radio2'))?>
                                    <label for="radio2" class="b-radio-icons_label">
                                        <span class="ico-male"></span>
                                    </label>
                                    <!-- Данные для примера id="radio3" name="b-radio2" и for="radio3" -->
                                    <!--<input type="radio" name="b-radio2" id="radio3" class="b-radio-icons_radio">-->
                                    <?=$form->radioButton($model, 'gender', array('value' => '0', 'class' => 'b-radio-icons_radio', 'id' => 'radio3'))?>
                                    <label for="radio3" class="b-radio-icons_label">
                                        <span class="ico-female"></span>
                                    </label>
                                </div>
                                <div class="errorMessage">Выберите пол</div>
                            </div>
                        </div>
                    </div>
                    <div class="b-sign_hr margin-b30"></div>


                    <div class="margin-b40 clearfix">
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Пароль</label>
                            </div>
                            <div class="b-sign_itx-hold error">
                                <input type="password" name="" id="" class="itx-simple">
                                <div class="errorMessage">Введите минимум 6 знаков</div>
                                <div class="b-sign_itx-desc">Придумайте сложный пароль, от 6 до 12 символов - цифры и английские буквы.</div>
                            </div>
                        </div>
                        <div class="float-l w-50p">
                            <div class="b-sign_label-hold">
                                <label for="" class="b-sign_label">Пароль <br>еще раз</label>
                            </div>
                            <div class="b-sign_itx-hold error">
                                <input type="text" name="" id="" class="itx-simple">
                                <div class="errorMessage">Пароли не совпадают</div>
                            </div>
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