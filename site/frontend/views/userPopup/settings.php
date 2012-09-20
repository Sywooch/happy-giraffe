<div id="user-settings" class="clearfix">

    <div class="header">

        <div class="title">
            <span>Мои настройки</span>
        </div>

        <div class="nav">
            <ul>
                <li><a href="javascript:void(0)" onclick="Settings.openTab(0)">Личные данные</a></li>
                <li><a href="javascript:void(0)" onclick="Settings.openTab(1)">Социальные сети</a></li>
                <li><a href="javascript:void(0)" onclick="Settings.openTab(2)">Пароль</a></li>
            </ul>
        </div>

        <a href="javascript:void(0)" onclick="Settings.close()" class="close">Закрыть настройки</a>

    </div>

    <div class="settings">

        <span class="ava male"></span>

        <div class="settings-in" style="display: none;">

            <div class="settings-form">

                <div class="row clearfix">

                    <div class="row-title">Имя:</div>

                    <div class="row-elements">
                        <span class="value-big">Александр</span>
                        <a href="" class="edit tooltip" title="Изменить"></a>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Фамилия:</div>

                    <div class="row-elements">
                        <span class="value-big">Кувыркин</span>
                        <a href="" class="edit tooltip" title="Изменить"></a>
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Фамилия:</div>

                    <div class="row-elements">
                        <input type="text" />
                        <button class="btn-green small">Ok</button>
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Дата рождения:</div>

                    <div class="row-elements">
                        <span class="value">28 сентября (30 лет)</span>
                        <a href="" class="edit tooltip" title="Изменить"></a>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Дата рождения:</div>

                    <div class="row-elements">

							<span class="chzn-v2">
								<select class="chzn w-1">
                                    <option>29</option>
                                    <option>29</option>
                                </select>
							</span>
							<span class="chzn-v2">
								<select class="chzn w-2">
                                    <option>Сентября</option>
                                    <option>Сентября</option>
                                </select>
							</span>
							<span class="chzn-v2">
								<select class="chzn w-3">
                                    <option>2005</option>
                                    <option>2005</option>
                                </select>
							</span>
                        <button class="btn-green small">Ok</button>
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Пол:</div>

                    <div class="row-elements">
                        <input type="radio" />
                        <label>Женщина</label>
                        &nbsp;
                        <input type="radio" />
                        <label>Мужчина</label>
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">E-mail:</div>

                    <div class="row-elements">
                        <span class="value">akuv@mail.ru</span>
                        <a href="" class="edit tooltip" title="Изменить"></a>

                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">E-mail:</div>

                    <div class="row-elements">
                        <input type="text" placeholder="Введите ваш e-mail" />
                        <button class="btn-green small">Ok</button>
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Участник</div>

                    <div class="row-elements">
                        с 18 декабря 2012
                    </div>

                </div>

                <div class="row clearfix">

                    <div class="row-title">Удалить анкету:</div>

                    <div class="row-elements">
                        <p>Да, я хочу <a href="" class="delete">Удалить анкету</a>, потеряв всю введенную информацию
                            без возможности восстановления.</p>
                    </div>

                </div>

            </div>

        </div>

        <div class="settings-in" style="display: none;">

            <div class="socials">

                <p>Свяжите свой профиль с вашими аккаунтами на других сайтах. <br/>Это позволит входить на сайт, используя любой из привязанных аккаунтов.</p>

                <div class="profiles-list">

                    <div class="list-title clearfix">

                        <div class="col col-1">Социальная сеть</div>
                        <div class="col col-2">Имя</div>
                        <div class="col col-3">Удалить профиль </div>

                    </div>

                    <ul>
                        <li class="clearfix">
                            <div class="col col-1"><span class="social-logo vkontakte"></span></div>
                            <div class="col col-2"><a href="">Александр Кувыркин</a></div>
                            <div class="col col-3"><a href="" class="btn-remove"><i class="icon"></i>Удалить профиль</a></div>
                        </li>
                        <li class="clearfix">
                            <div class="col col-1"><span class="social-logo facebook"></span></div>
                            <div class="col col-2"><a href="">Александр Кувыркин</a></div>
                            <div class="col col-3"><a href="" class="btn-remove"><i class="icon"></i>Удалить профиль</a></div>
                        </li>
                        <li class="clearfix">
                            <div class="col col-1"><span class="social-logo odnoklassniki"></span></div>
                            <div class="col col-2"><a href="">Александр Кувыркин</a></div>
                            <div class="col col-3"><a href="" class="btn-remove"><i class="icon"></i>Удалить профиль</a></div>
                        </li>
                        <li class="clearfix">
                            <div class="col col-1"><span class="social-logo mailru"></span></div>
                            <div class="col col-2"><a href="">Александр Кувыркин</a></div>
                            <div class="col col-3"><a href="" class="btn-remove"><i class="icon"></i>Удалить профиль</a></div>
                        </li>

                    </ul>

                </div>

                <div class="add-profile">

                    <div class="block-title">Добавить профиль</div>

                    <ul class="auth-services">
                        <li class="auth-service mailru"><a href="" class="auth-link mailru"></a></li>
                        <li class="auth-service odnoklassniki"><a href="" class="auth-link odnoklassniki"></a></li>
                        <li class="auth-service vkontakte"><a href="" class="auth-link vkontakte"></a></li>
                        <li class="auth-service facebook"><a href="" class="auth-link facebook"></a></li>
                    </ul>

                </div>

            </div>

        </div>

        <div class="settings-in" style="display: none;">

            <div class="settings-form password-form">

                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'password-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'action' => array('userPopup/changePassword'),
                    'htmlOptions' => array(
                        'onsubmit' => 'Settings.changePassword(this); return false;',
                    ),
                ));?>

                    <div class="row clearfix">

                        <div class="row-title">Текущий пароль:</div>

                        <div class="row-elements">
                            <?=$form->passwordField($model, 'current_password', array('class' => 'input-big'))?><br/>
                            <?=$form->error($model, 'current_password')?>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="row-title">Новый пароль:</div>

                        <div class="row-elements">
                            <?=$form->passwordField($model, 'new_password', array('class' => 'input-big'))?><br/>
                            <?=$form->error($model, 'new_password')?>
                            <div class="small">Придумайте сложный пароль</div>
                        </div>

                    </div>

                    <div class="row clearfix">

                        <div class="row-title">Новый пароль<br/>еще раз:</div>

                        <div class="row-elements">
                            <?=$form->passwordField($model, 'new_password_repeat', array('class' => 'input-big'))?>
                            <?=$form->error($model, 'new_password_repeat')?>
                        </div>

                    </div>

                    <div class="row clearfix row-captcha">

                        <div class="row-title">Код:</div>

                        <div class="row-elements">

                            <div class="col">
                                <div class="captcha-img"><?php $this->widget('Captcha', array('showRefreshButton' => FALSE, 'selector' => '.refresh')); ?></div>
                                <a href="javascript:void(0)" class="refresh">Обновить картинку<i class="icon"></i></a>
                            </div>

                            <div class="col">
                                <?=$form->textField($model, 'verifyCode', array('class' => 'input-big'))?><br/>
                                <div class="small">Введите цифры, которые Вы видите на картинке.</div>
                            </div>

                        </div>

                    </div>

                    <div class="row clearfix row-captcha">

                        <div class="row-title">&nbsp;</div>

                        <div class="row-elements">

                            <button class="btn-orange">Изменить</button>

                        </div>

                    </div>

                <?php $this->endWidget(); ?>

            </div>

        </div>

    </div>

</div>