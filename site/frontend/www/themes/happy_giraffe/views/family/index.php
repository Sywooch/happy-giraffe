<?php
/* @var $this Controller
 * @var $user User
 */
?>
<div class="user-cols clearfix">

    <div class="col-1">
        <?php $this->widget('application.widgets.user.FamilyWidget', array('user' => $user)); ?>
    </div>

    <div class="col-23 clearfix">

        <div class="family">

            <div class="content-title">Моя семья</div>

            <div class="family-radiogroup">
                <div class="title">Семейное положение</div>
                <div class="radiogroup">
                    <?php foreach ($user->getRelashionshipList() as $status_key => $status_text): ?>
                        <div class="radio-label<?php if ($user->relationship_status == $status_key) echo ' checked' ?>" onclick="Family.setStatusRadio(this, <?=$status_key ?>);"><span><?=$status_text ?></span><input type="radio" name="radio-<?=$status_key ?>"></div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($user->hasPartner()):?>
                <div class="family-member">

                    <div class="data clearfix">

                        <div class="d-text"><?=$user->getPartnerTitleForName() ?>:</div>

                        <div class="name">
                            <div class="text"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>><?=$user->partner->name ?></div>
                            <div class="input"<?php if (!empty($user->partner->name)) echo ' style="display:none;"' ?>>
                                <input type="text">
                                <button class="btn btn-green-small"><span><span>Ok</span></span></button>
                            </div>
                            <a href="javascript:void(0);" class="edit"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>><span class="tip">Редактировать имя</span></a>
                        </div>

                        <div<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>>
                            <div class="date">
                                <a href="javascript:void(0);" class="date"><span class="tip">Укажите дату рождения</span></a>
                                <div class="datepicker">
                                    <div class="tale"></div>
                                    <select class="chzn w-1 chzn-done" id="selV1H" style="display: none; ">
                                        <option>28</option>
                                        <option>29</option>
                                        <option>30</option>
                                    </select><div id="selV1H_chzn" class="chzn-container chzn-container-single" style="width: 62px; "><a href="javascript:void(0)" class="chzn-single"><span>28</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 60px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 42px; "></div><ul class="chzn-results"><li id="selV1H_chzn_o_0" class="active-result result-selected" style="">28</li><li id="selV1H_chzn_o_1" class="active-result" style="">29</li><li id="selV1H_chzn_o_2" class="active-result" style="">30</li></ul></div></div>
                                    &nbsp;
                                    <select class="chzn w-2 chzn-done" id="selF6Q" style="display: none; ">
                                        <option>января</option>
                                        <option>февраля</option>
                                        <option>марта</option>
                                    </select><div id="selF6Q_chzn" class="chzn-container chzn-container-single" style="width: 122px; "><a href="javascript:void(0)" class="chzn-single"><span>января</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 120px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 102px; "></div><ul class="chzn-results"><li id="selF6Q_chzn_o_0" class="active-result result-selected" style="">января</li><li id="selF6Q_chzn_o_1" class="active-result" style="">февраля</li><li id="selF6Q_chzn_o_2" class="active-result" style="">марта</li></ul></div></div>
                                    &nbsp;
                                    <select class="chzn w-3 chzn-done" id="sel9V4" style="display: none; ">
                                        <option>1981</option>
                                        <option>1982</option>
                                        <option>1982</option>
                                    </select><div id="sel9V4_chzn" class="chzn-container chzn-container-single" style="width: 82px; "><a href="javascript:void(0)" class="chzn-single"><span>1981</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 80px; top: 0px; "><div class="chzn-search" style=""><input type="text" autocomplete="off" style="width: 62px; "></div><ul class="chzn-results"><li id="sel9V4_chzn_o_0" class="active-result result-selected" style="">1981</li><li id="sel9V4_chzn_o_1" class="active-result" style="">1982</li><li id="sel9V4_chzn_o_2" class="active-result" style="">1982</li></ul></div></div>
                                    &nbsp;
                                    <button class="btn btn-green-small"><span><span>Ok</span></span></button>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="comment"><span class="tip">Расскажите о нем</span></a>
                            <a href="javascript:void(0);" class="photo"><span class="tip">Добавить 2 фото</span></a>
                        </div>
                    </div>

                    <div class="comment">
                        <div class="input" style="display:none;">
                            <div class="tale"></div>
                            <textarea>Очень любит готовить и воспитывать детей очень добрая и отзывчивая</textarea>
                            <button class="btn btn-green-small"><span><span>Ok</span></span></button>
                        </div>
                        <div class="text">Очень любит готовить и воспитывать детей очень добрая и отзывчивая <a href="javascript:void(0);" class="edit"><span class="tip">Редактировать комментарий</span></a></div>
                    </div>

                    <div class="photos">
                        <ul>
                            <li>
                                <img src="/images/example/ex3.jpg">
                                <a href="" class="remove"></a>
                            </li>
                            <li>
                                <img src="/images/example/ex4.jpg">
                                <a href="" class="remove"></a>
                            </li>
                            <li class="add">
                                <a href="">
                                    <i class="icon"></i>
                                    <span>Загрузить еще<br> 2 фотографии</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            <?php endif ?>

        </div>

    </div>
</div>