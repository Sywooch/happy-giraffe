<div id="first-steps">

    <div class="block-title">

        <div class="right">
            <div class="bonus">
                бонус <img src="/images/first_steps_bonus.png">
            </div>
            <a href="javascript:void(0);" class="toggler toggled" data-title="Осталось шагов: 4" data-close="Свернуть" onclick="firstStepsToggle(this);"><span>Свернуть</span><i class="icon"></i></a>
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
                    </li>
                    <li>
                        <div class="num">Шаг 3</div>
                        <div class="text"><a href="#firstStepsLocation" class="fancy">Укажите ваше место жительства</a></div>
                    </li>
                    <li>
                        <div class="num">Шаг 4</div>
                        <div class="text"><a href="">Загрузите ваше главное фото</a></div>
                    </li>
                    <li>
                        <div class="num">Шаг 5</div>
                        <div class="text"><a href="">Расскажите о вашей семье</a></div>
                    </li>
                    <li>
                        <div class="num">Шаг 6</div>
                        <div class="text"><a href="">Укажите ваши интересы</a></div>
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

        <div class="clearfix">

            <div class="left">
                <img src="/images/first_steps_location.png">
            </div>

            <div class="right">

                <div class="title">Укажите ваше место жительства!</div>

                <div class="select-box">
                    <div class="row">
                        Место жительства:<br>
						<span class="chzn-v2">
							<select class="chzn w-1 chzn-done" data-placeholder="Страна" id="selGK3" style="display: none; "><option>28</option></select><div id="selGK3_chzn" class="chzn-container chzn-container-single" style="width: 147px; "><a href="javascript:void(0)" class="chzn-single"><span>28</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 145px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 117px; "></div><ul class="chzn-results"><li id="selGK3_chzn_o_0" class="active-result result-selected" style="">28</li></ul></div></div>
						</span>
                        &nbsp;&nbsp;
						<span class="chzn-v2">
							<select class="chzn w-2 chzn-done" data-placeholder="Регион" id="selAPJ" style="display: none; "><option>28</option></select><div id="selAPJ_chzn" class="chzn-container chzn-container-single" style="width: 232px; "><a href="javascript:void(0)" class="chzn-single"><span>28</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 230px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 202px; "></div><ul class="chzn-results"><li id="selAPJ_chzn_o_0" class="active-result result-selected" style="">28</li></ul></div></div>
						</span>
                    </div>
                    <div class="row">
                        Населенный пункт:<br>
                        <input type="text" class="w-3">
                        <br>
                        <small>Введите свой город, поселок, село или деревню</small>
                    </div>

                </div>

                <span class="hl">Наш подарок: виджет с погодой на каждый день!</span>

            </div>

        </div>

        <div class="bottom">
            <button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
        </div>

    </div>

    <div id="firstStepsBirthday" class="popup">

        <div class="clearfix">

            <div class="left">
                <img src="/images/first_steps_birthday.png">
            </div>

            <div class="right">

                <div class="title">Укажите вашу дату рождения</div>

                <div class="select-box">
                    Дата рождения:
					<span class="chzn-v2">
                        <?=CHtml::dropDownList() ?>
						<select class="chzn w-1 chzn-done" id="sel98G" style="display: none; "><option>28</option></select><div id="sel98G_chzn" class="chzn-container chzn-container-single" style="width: 32px; "><a href="javascript:void(0)" class="chzn-single"><span>28</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 30px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 12px; "></div><ul class="chzn-results"><li id="sel98G_chzn_o_0" class="active-result result-selected" style="">28</li></ul></div></div>
					</span>
					<span class="chzn-v2">
						<select class="chzn w-2 chzn-done" id="selXS8" style="display: none; "><option>января</option></select><div id="selXS8_chzn" class="chzn-container chzn-container-single" style="width: 92px; "><a href="javascript:void(0)" class="chzn-single"><span>января</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 90px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 72px; "></div><ul class="chzn-results"><li id="selXS8_chzn_o_0" class="active-result result-selected" style="">января</li></ul></div></div>
					</span>
					<span class="chzn-v2">
						<select class="chzn w-3 chzn-done" id="sel14Q" style="display: none; "><option>1973</option></select><div id="sel14Q_chzn" class="chzn-container chzn-container-single" style="width: 62px; "><a href="javascript:void(0)" class="chzn-single"><span>1973</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 60px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 42px; "></div><ul class="chzn-results"><li id="sel14Q_chzn_o_0" class="active-result result-selected" style="">1973</li></ul></div></div>
					</span>

                </div>

                <span class="hl">И мы подарим вам виджет с гороскопом на каждый день!</span>

            </div>

        </div>

        <div class="bottom">
            <button class="btn btn-green-medium"><span><span>Сохранить</span></span></button>
        </div>

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