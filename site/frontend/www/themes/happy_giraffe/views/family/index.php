<?php
/* @var $this Controller
 * @var $user User
 */
$js = '
    Family.userId='.$user->id.';
    Family.partner_id='.$user->partner->id.';
    Family.partnerOf = '.CJavaScript::encode($user->getPartnerTitlesOf()).';
';
Yii::app()->clientScript->registerScript('family-edit',$js);
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
                <div class="family-member" id="user-partner">

                    <div class="data clearfix">

                        <div class="d-text">Имя <span><?=$user->getPartnerTitleOf() ?></span>:</div>

                        <div class="name">
                            <div class="text"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>><?=$user->partner->name ?></div>
                            <div class="input"<?php if (!empty($user->partner->name)) echo ' style="display:none;"' ?>>
                                <input type="text">
                                <button class="btn btn-green-small" onclick="Family.savePartnerName(this);"><span><span>Ok</span></span></button>
                            </div>
                            <a href="javascript:void(0);" onclick="Family.editPartnerName(this)" class="edit"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>><span class="tip">Редактировать имя</span></a>
                        </div>

                        <div<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>>
                            <div class="age"<?php if (empty($user->partner->birthday)) echo ' style="display:none;"' ?>>
                                <?=$user->partner->getAge() ?>
                            </div>
                            <div class="date">
                                <a href="javascript:void(0);" onclick="Family.editDate(this);" class="date"><span class="tip">Укажите дату рождения</span></a>
                                <div class="datepicker" style="display:none;">
                                    <div class="tale"></div>
                                    <?php echo CHtml::dropDownList('partner_d', $user->partner->getBDatePart('d'), array(''=>' ')+HDate::Days(), array(
                                        'class'=>'chzn w-50 date',
                                        'data-placeholder'=>' '
                                    )) ?>
                                    &nbsp;
                                    <?php echo CHtml::dropDownList('partner_m', $user->partner->getBDatePart('n'), array(''=>' ')+HDate::ruMonths(), array(
                                        'class'=>'chzn w-100 month',
                                        'data-placeholder'=>' '
                                    )) ?>
                                    &nbsp;
                                    <?php echo CHtml::dropDownList('partner_y', $user->partner->getBDatePart('Y'), array(''=>' ')+HDate::Range(date('Y')-16, date('Y') - 100), array(
                                        'class'=>'chzn w-50 year',
                                        'data-placeholder'=>' '
                                    )) ?>
                                    &nbsp;
                                    <button class="btn btn-green-small" onclick="Family.saveDate(this)"><span><span>Ok</span></span></button>
                                </div>
                            </div>
                            <a href="javascript:void(0);" onclick="Family.editPartnerNotice(this)" class="comment"><span class="tip">Расскажите о нем</span></a>
                            <a href="javascript:void(0);" class="photo"><span class="tip">Добавить 2 фото</span></a>
                        </div>
                    </div>

                    <div class="comment"<?php if (empty($user->partner->notice)) echo ' style="display:none;"' ?>>
                        <div class="input" style="display:none;">
                            <div class="tale"></div>
                            <textarea><?=$user->partner->notice ?></textarea>
                            <button class="btn btn-green-small" onclick="Family.savePartnerNotice(this)"><span><span>Ok</span></span></button>
                        </div>
                        <div class="text"><span class="text"><?=$user->partner->notice ?></span> <a href="javascript:void(0);" onclick="Family.editPartnerNotice(this)" class="edit"><span class="tip">Редактировать комментарий</span></a></div>
                    </div>

                </div>
            <?php endif ?>

        </div>

    </div>
</div>