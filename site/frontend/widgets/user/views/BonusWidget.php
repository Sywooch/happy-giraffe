<?php
/* @var $this BonusWidget
 * @var $form CActiveForm
 */

$steps_count = 0;
if (empty($this->user->getUserAddress()->country_id)) $steps_count++;
if (empty($this->user->birthday)) $steps_count++;
if (empty($this->user->avatar)) $steps_count++;
if (empty($this->user->relationship_status)) $steps_count++;
if (empty($this->user->interests)) $steps_count++;
?><div id="first-steps">

    <div class="block-title">

        <div class="right">
            <div class="bonus">
                бонус <img src="/images/first_steps_bonus.png">
            </div>
            <a href="javascript:void(0);" class="toggler toggled" data-title="Осталось шагов: <?=$steps_count ?>" data-close="Свернуть" onclick="firstStepsToggle(this);"><span>Свернуть</span><i class="icon"></i></a>
        </div>

        <div class="title-in">Ваши первые шаги</div>

    </div>

    <div class="block-in clearfix">

        <div class="container clearfix">
            <div class="steps-list">
                <ul>
                    <li class="strike">
                        <div class="num">Шаг 1</div>
                        <div class="text"><a href="#firstStepsEmail" class="fancy">Подтвердите ваш e-mail</a></div>
                        <div class="done"><i class="icon"></i>Сделано</div>
                    </li>
                    <li>
                        <div class="num">Шаг 2</div>
                        <div class="text"><a href="#firstStepsBirthday" class="fancy">Укажите вашу дату рождения</a></div>
                    <div class="done">
                        <?php if (!empty($this->user->birthday)):?>
                            <i class="icon"></i>Сделано
                        <?php endif ?>
                    </div>
                    </li>
                    <li>
                        <div class="num">Шаг 3</div>
                        <div class="text"><a href="#firstStepsLocation" class="fancy">Укажите ваше место жительства</a></div>
                        <?php if (!empty($this->user->getUserAddress()->country_id)):?>
                            <div class="done"><i class="icon"></i>Сделано</div>
                        <?php endif ?>
                    </li>
                    <li>
                        <div class="num">Шаг 4</div>
                        <div class="text"><a href="javascript:;" onclick="$('#change_ava > div.photo > a').trigger('click');">Загрузите ваше главное фото</a></div>
                        <?php if (!empty($this->user->avatar)):?>
                            <div class="done"><i class="icon"></i>Сделано</div>
                        <?php endif ?>
                    </li>
                    <li>
                        <div class="num">Шаг 5</div>
                        <div class="text"><a href="/family/">Расскажите о вашей семье</a></div>
                        <?php if (!empty($this->user->relationship_status)):?>
                            <div class="done"><i class="icon"></i>Сделано</div>
                        <?php endif ?>
                    </li>
                    <li>
                        <div class="num">Шаг 6</div>
                        <div class="text"><a href="/ajax/interestsForm/" class="fancy">Укажите ваши интересы</a></div>
                    <div class="done">
                        <?php if (!empty($this->user->interests)):?>
                            <i class="icon"></i>Сделано
                        <?php endif ?>
                    </div>
                    </li>

                </ul>
            </div>

            <div class="info">
                <p><span>6 шагов</span> и вы сможете пользоваться всеми функциями сайта</p>
                <div class="bonus">
                    <div class="bonus-left">
                        <img src="/images/first_steps_bonus_plus.png"> от нас бонусна
                        <span>дополнительные опции сайта</span>
                    </div>
                    <img src="/images/first_steps_bonus_big.png">
                </div>
            </div>
        </div>
    </div>
</div>

<div style="display: none;">
    <div id="firstStepsLocation" class="popup">
        <form method="post" action="<?php echo Yii::app()->createUrl('/user/saveLocation'); ?>" class="clearfix">

        <div class="clearfix">

            <div class="left">
                <img src="/images/first_steps_location.png">
            </div>

            <div class="right">
                <?php $regions = array('' => '');
                if ($this->user->getUserAddress()->country_id !== null) {
                    $regions = array('' => ' ') + CHtml::listData(GeoRegion::model()->findAll(array(
                        'order' => 'position, name', 'select' => 'id,name', 'condition' => 'country_id = ' . $this->user->getUserAddress()->country_id)), 'id', 'name');
                } ?>

                <div class="title">Укажите ваше место жительства!</div>

                <div class="select-box">
                    <div class="row">
                        Место жительства:<br>
						<span class="chzn-v2">
							<?php echo CHtml::dropDownList('country_id', $this->user->getUserAddress()->country_id,
                            array('' => ' ') + CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'),
                            array(
                                'class' => 'chzn w-1',
                                'data-placeholder' => 'Страна',
                                'onchange' => 'UserLocation.SelectCounty($(this));'
                            )) ?>
						</span>
                        &nbsp;&nbsp;
						<span class="chzn-v2">
							<?php echo CHtml::dropDownList('region_id', $this->user->getUserAddress()->region_id, $regions,
                            array(
                                'class' => 'chzn w-2',
                                'data-placeholder' => 'Регион',
                                'onchange' => 'UserLocation.RegionChanged($(this));'
                            )); ?>
						</span>
                    </div>
                    <div class="row settlement"<?php if ($this->user->getUserAddress()->region !== null && $this->user->getUserAddress()->region->isCity()) echo ' style="display:none;"' ?>>
                        Населенный пункт:<br>
                        <?php
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'id' => 'city_name',
                            'name' => 'city_name',
                            'value' => ($this->user->userAddress->city === null) ? '' : $this->user->userAddress->city->name,
                            'source' => "js: function(request, response){
                            $.ajax({
                                url: '" . Yii::app()->createUrl('/geo/default/cities') . "',
                                dataType: 'json',
                                data: {
                                    term: request.term,
                                    country_id: $('#country_id').val(),
                                    region_id: $('#region_id').val()
                                },
                                success: function (data)
                                {
                                    response(data);
                                }
                            })
                        }",
                            'options' => array(
                                'select' => "js:function (event, ui)
                                {
                                    $('#city_id').val(ui.item.id);
                                }
                            ",
                                'htmlOptions' => array(
                                    'placeholder' => 'Выберите город',
                                    'class'=>'w-3'
                                )
                            ),
                        ));
                        ?>
                        <?php echo CHtml::hiddenField('city_id', $this->user->userAddress->city_id); ?>
                        <br>
                        <small>Введите свой город, поселок, село или деревню</small>
                    </div>

                </div>

                <span class="hl">Наш подарок: виджет с погодой на каждый день!</span>

            </div>

        </div>

        <div class="bottom">
            <button class="btn btn-green-medium" onclick="UserLocation.saveLocation();return false;"><span><span>Сохранить</span></span></button>
        </div>

        </form>

    </div>

    <div id="firstStepsBirthday" class="popup">
        <style type="text/css">
            #firstStepsBirthday .errorMessage {
                display: none !important;
            }
        </style>

        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'birthday-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'action' => '/ajax/birthday/',
        'clientOptions' => array(
            'inputContainer'=>'.chzn-v2',
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => '/ajax/birthday/',
            'afterValidate' => "js:function(form, data, hasError) {
                                if (!hasError)
                                    Bonus.setBirthday();
                                return false;
                              }",
        )));
        $model = new DateForm();
        if (!empty($this->user->birthday)){
            $birthday = strtotime($this->user->birthday);
            $model->day = date("j", $birthday);
            $model->month = date("n", $birthday);
            $model->year = date("Y", $birthday);
        }
        ?>

        <div class="clearfix">

            <div class="left">
                <img src="/images/first_steps_birthday.png">
            </div>
            <?=$form->error($model, 'birthday') ?>

            <div class="right">

                <div class="title">Укажите вашу дату рождения</div>

                <div class="select-box">
                    Дата рождения:
					<span class="chzn-v2">
                        <?=$form->dropDownList($model, 'day', HDate::Range(1,31), array('class'=>'chzn w-1', 'empty'=>'День')) ?>
                        <?=$form->error($model, 'day') ?>
					</span>
					<span class="chzn-v2">
                        <?=$form->dropDownList($model, 'month', HDate::ruMonths(), array('class'=>'chzn w-2', 'empty'=>'Месяц')) ?>
                        <?=$form->error($model, 'month') ?>
					</span>
					<span class="chzn-v2">
						<?=$form->dropDownList($model, 'year', HDate::Range(date('Y')-18, 1900), array('class'=>'chzn w-3', 'empty'=>'Год')) ?>
                        <?=$form->error($model, 'year') ?>
					</span>

                </div>

                <span class="hl">И мы подарим вам виджет с гороскопом на каждый день!</span>

            </div>

        </div>

        <div class="bottom">
            <button class="btn btn-green-medium" onclick="$(this).parents('form').submit();return false;"><span><span>Сохранить</span></span></button>
        </div>
        <?php $this->endWidget(); ?>
    </div>


    <div id="firstStepsEmail" class="popup">

        <div class="clearfix">

            <div class="left">
                <img src="/images/first_steps_email.png">
            </div>

            <div class="right">

                <div class="title">Вам отправлено письмо!</div>

                <p>Мы отправили вам письмо, для <br> <span class="hl">подтверждения адреса электронной почты</span></p>

                <p>Просим вас открыть ваш почтовый ящик,<br> <span class="hl">найти наше письмо и нажать на кнопку <span>«Подтвердить e-mail»</span></span></p>

                <p>Если вы не обнаружили письмо, <span class="note">*</span><br> мы можем отправить его еще раз <a href="" class="orange">Отправить письмо</a></p>

            </div>

        </div>

        <div class="bottom">
            <div><span class="note">*</span> Просим вас проверить папку "Спам"</div>
        </div>

    </div>
</div>