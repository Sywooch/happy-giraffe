<?php
    /* @var $this Controller
     * @var $user User
     * @var $future_baby Baby
     */
    $js = '
        Family.userId='.$user->id.';
        Family.partner_id='.$user->partner->id.';
        Family.partnerOf = '.CJavaScript::encode($user->getPartnerTitlesOf()).';
        Family.baby_count = '.$user->babyCount().';
        Family.future_baby_type = '.(($future_babies[0] === null) ? 'null' : $future_babies[0]->type).';
        Family.relationshipStatus = '.(($user->relationship_status === null) ? 'null' : $user->relationship_status).';
    ';

    $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
    $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

    Yii::app()->clientScript
        ->registerScript('family-edit',$js)
        ->registerScriptFile($baseUrl. '/family.js?35', CClientScript::POS_HEAD)
        ->registerScriptFile('/javascripts/jquery.masonry.min.js')
        ->registerScriptFile('/javascripts/album.js')
    ;


    if ($user->getSystemAlbum(3) !== null) {
        $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
            'selector' => '.img > a',
            'entity' => 'Album',
            'entity_id' => $user->getSystemAlbum(3)->id,
        ));
    }

?>

<div class="user-cols clearfix">

    <div class="col-1">

        <div class="clearfix user-info-big">
            <?php
                $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $this->user,
                    'location' => false,
                    'friendButton' => true,
                    'nav' => true,
                    'status' => true,
                ));
            ?>
        </div>

        <div id="family-widget-container">
            <?php $this->widget('application.widgets.user.FamilyWidget', array('user' => $user)); ?>
        </div>

    </div>

    <div class="col-23 clearfix">

        <div class="family">

            <div class="content-title-new">Моя семья</div>

            <div class="family-radiogroup">
                <div class="title">Семейное положение<span class="relationship-status"<?php if ($user->relationship_status === null): ?> style="display: none;"<?php endif; ?>> <span class="title"><?=$user->relationshipStatusString?></span> <a href="javascript:void(0)" class="pseudo" onclick="Family.changeStatus()">Изменить</a></span></div>
                <div class="relationship-choice"<?php if ($user->relationship_status !== null): ?> style="display: none;"<?php endif; ?>>
                    <div class="subtitle">Выберите один из вариантов вашего семейного положения.</div>
                    <div class="radiogroup">
                        <?php foreach ($user->getRelashionshipList() as $status_key => $status_text): ?>
                            <div class="radio-label<?php if ($user->relationship_status == $status_key) echo ' checked' ?>" onclick="Family.setStatusRadio(this, <?=$status_key ?>);"><span><?=$status_text ?></span><input type="radio" name="radio-<?=$status_key ?>"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="family-member" id="user-partner"<?php if (!$user->hasPartner()) echo ' style="display:none;"' ?>>

                <p>Расскажите немного о <span class="partner-title"><?=$user->getPartnerTitleOf(null, 4)?></span> и загрузите её фото (по желанию)</p>

                <div class="data clearfix">

                    <div class="d-text">Имя <span><?=$user->getPartnerTitleOf() ?></span>:</div>

                    <div class="name">
                        <div class="text"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>><?=$user->partner->name ?></div>
                        <div class="input"<?php if (!empty($user->partner->name)) echo ' style="display:none;"' ?>>
                            <input type="text">
                            <button class="btn btn-green-small" onclick="Family.savePartnerName(this);"><span><span>Ok</span></span></button>
                        </div>
                        <a href="javascript:void(0);" onclick="Family.editPartnerName(this)" class="edit tooltip"<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?> title="Редактировать имя"></a>
                    </div>
                </div>

                <div class="data clearfix">
                    <div class="d-text">О <span><?=$user->getPartnerTitleOf(null, 1) ?></span>:</div>
                    Добавьте короткий рассказ (не более 100 знаков)
                    <div class="comment">
                        <span class="tale"></span>
                        <div class="input"<?php if (! empty($user->partner->notice)) echo ' style="display:none;"' ?>>
                            <textarea maxlength="100"><?=$user->partner->notice?></textarea>
                            <button class="btn btn-green-small" onclick="Family.savePartnerNotice(this)"><span><span>Ok</span></span></button>
                        </div>
                        <div class="text"<?php if (empty($user->partner->notice)) echo ' style="display:none;"' ?>>
                            <span class="text"><?=$user->partner->notice?></span>
                            <a href="javascript:void(0);" onclick="Family.editPartnerNotice(this)" class="edit tooltip" title="Редактировать"></a>
                            <a href="javascript:void(0);" onclick="Family.delPartnerNotice(this)" class="remove tooltip" title="Удалить"></a>
                        </div>
                    </div>
                </div>

                <div class="data clearfix">

                    <div class="d-text">Фото <span><?=$user->getPartnerTitleOf() ?></span>:</div>
                    Загрузите фото, нажав на кнопку “+”

                    <div class="gallery-photos-new cols-3 clearfix">
                        <ul data-entity-id="<?=$user->partner->id?>" data-entity="<?=get_class($user->partner)?>">

                            <li class="add">
                                <?php
                                    $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                        'model' => $user->partner,
                                        'customButton' => true,
                                    ));
                                ?>
                                <i class="icon"></i>
                                <span>Загрузить  еще фото</span>
                                <?php
                                    $this->endWidget();
                                ?>
                            </li>

                            <?php foreach ($user->partner->photos as $k => $p): ?>
                                <?php
                                    $photo = $p->photo;
                                    if (! $photo->title)
                                        $photo->title = $user->getPartnerTitleOf(null, 2) . ' - фото ' . ($k + 1);
                                ?>
                                <?php $this->renderPartial('//albums/_photo', array('data' => $photo)); ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>

            </div>

            <div class="family-radiogroup">
                <div class="title">Мои дети <span class="baby-status"<?php if ($user->babyCount(true) == 0): ?> style="display: none;"<?php endif; ?>><span class="title"><?=$user->babyString?></span> <a href="javascript:void(0)" onclick="Family.changeBabies()" class="pseudo">Изменить</a></span><small class="baby-notice"<?php if ($user->babyCount(true) > 0): ?> style="display: none;"<?php endif; ?>>(а также планирование и беременность)</small></div>
                <div class="baby-choice"<?php if ($user->babyCount(true) > 0): ?> style="display: none;"<?php endif; ?>>
                    <div class="subtitle">Выберите один или два варианта ответа (если у вас более 3-х детей нажмите на кнопку "+")</div>
                    <div class="radiogroup">
                        <div class="radio-label<?php if($user->hasBaby(Baby::TYPE_PLANNING) == 1) echo ' checked'?>" onclick="Family.setFutureBaby(this, <?=Baby::TYPE_PLANNING ?>);"><span>Планируем</span><input type="radio" name="radio-2"></div>
                        <div class="radio-label<?php if($user->hasBaby(Baby::TYPE_WAIT) == 1) echo ' checked'?>" onclick="Family.setFutureBaby(this, <?=Baby::TYPE_WAIT ?>);"><span>Ждем<i class="icon-waiting"></i></span><input type="radio" name="radio-2"></div>

                        <div class="radio-label<?php if($user->babyCount() == 1) echo ' checked'?>" onclick="Family.setBaby(this, 1);"><span>1 ребенок</span><input type="radio" name="radio-3"></div>
                        <div class="radio-label<?php if($user->babyCount() == 2) echo ' checked'?>" onclick="Family.setBaby(this, 2);"><span>2 ребенка</span><input type="radio" name="radio-3"></div>
                        <div class="radio-label<?php if($user->babyCount() == 3) echo ' checked'?>" onclick="Family.setBaby(this, 3);"><span>3 ребенка</span><input type="radio" name="radio-3"></div>
                        <div class="radio-label" onclick="Family.addBabyRadio(this)"><span>+</span></div>
                    </div>
                </div>
            </div>

            <?php $i = 1; foreach ($user->babies as $baby): ?>
                <?php if (empty($baby->type)):?>
                    <div class="family-member" id="baby-<?=$i ?>">

                        <input type="hidden" value="<?=$baby->id ?>" class="baby-id">

                        <div class="member-title"><?=$i?>-<?=HDate::govnokod($i)?> ребенок:</div>

                        <div class="data clearfix">
                            <div class="d-text">Имя ребенка:</div>
                            <div class="name">
                                <div class="text"<?php if (empty($baby->name)) echo ' style="display:none;"' ?>><?=$baby->name ?></div>
                                <div class="input"<?php if (!empty($baby->name)) echo ' style="display:none;"' ?>>
                                    <input type="text">
                                    <button class="btn btn-green-small" onclick="Family.saveBabyName(this);"><span><span>Ok</span></span></button>
                                </div>
                                <a href="javascript:void(0);" onclick="Family.editBabyName(this)" class="edit tooltip"<?php if (empty($baby->name)) echo ' style="display:none;"' ?> title="Редактировать имя"></a>
                            </div>
                        </div>

                        <div class="data clearfix">
                            Пол и дата рождения ребенка:
                            <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 1)" class="gender male<?php if ($baby->sex == 1) echo ' active'?>"><span class="tip">Мальчик</span></a>
                            <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 0)" class="gender female<?php if ($baby->sex == 0) echo ' active'?>"><span class="tip">Девочка</span></a>

                            <div class="date">

                                <div class="datepicker"<?php if ($baby->birthday !== null): ?> style="display:none;"<?php endif; ?>>
                                    <span class="chzn-v2">
                                        <?php echo CHtml::dropDownList('baby_d_'.$i, $baby->getBDatePart('j'), array(''=>' ')+HDate::Days(), array(
                                        'class'=>'chzn w-1 date',
                                        'data-placeholder'=>' '
                                    )) ?>
                                    </span>
                                    &nbsp;
                                    <span class="chzn-v2">
                                        <?php echo CHtml::dropDownList('baby_m_'.$i, $baby->getBDatePart('n'), array(''=>' ')+HDate::ruMonths(), array(
                                        'class'=>'chzn w-2 month',
                                        'data-placeholder'=>' '
                                    )) ?>
                                    </span>
                                    &nbsp;
                                    <span class="chzn-v2">
                                        <?php echo CHtml::dropDownList('baby_y_'.$i, $baby->getBDatePart('Y'), array(''=>' ')+HDate::Range(date('Y'), date('Y') - 50), array(
                                        'class'=>'chzn w-3 year',
                                        'data-placeholder'=>' '
                                    )) ?>
                                    </span>
                                    &nbsp;
                                    <button class="btn btn-green-small" onclick="Family.saveBabyDate(this)"><span><span>Ok</span></span></button>
                                </div>

                                <div class="dateshower"<?php if ($baby->birthday === null): ?> style="display:none;"<?php endif; ?>>
                                    <div class="text"><span class="age"><?=$baby->textAge?></span>&nbsp;<a href="javascript:void(0);" onclick="Family.editDate(this);" class="edit tooltip" title="Редактировать имя"></a></div>
                                </div>

                            </div>


                        </div>

                        <div class="data clearfix">
                            Добавьте короткий рассказ (не более 100 знаков)
                            <div class="comment">
                                <span class="tale"></span>
                                <div class="input"<?php if (! empty($baby->notice)) echo ' style="display:none;"' ?>>
                                    <textarea maxlength="100"><?=$baby->notice?></textarea>
                                    <button class="btn btn-green-small" onclick="Family.saveBabyNotice(this)"><span><span>Ok</span></span></button>
                                </div>
                                <div class="text"<?php if (empty($baby->notice)) echo ' style="display:none;"' ?>>
                                    <span class="text"><?=$baby->notice?></span>
                                    <a href="javascript:void(0);" onclick="Family.editBabyNotice(this)" class="edit tooltip" title="Редактировать"></a>
                                    <a href="javascript:void(0);" onclick="Family.delBabyNotice(this)" class="remove tooltip" title="Удалить"></a>
                                </div>
                            </div>
                        </div>

                        <div class="gallery-photos-new cols-3 clearfix">
                            <ul data-entity-id="<?=$baby->id?>" data-entity="<?=get_class($baby)?>">

                                <li class="add">
                                    <?php
                                    $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                        'model' => $baby,
                                        'customButton' => true,
                                    ));
                                    ?>
                                    <i class="icon"></i>
                                    <span>Загрузить  еще фото</span>
                                    <?php
                                    $this->endWidget();
                                    ?>
                                </li>

                                <?php foreach ($baby->photos as $k => $p): ?>
                                    <?php $this->renderPartial('//albums/_photo', array('data' => $p->photo)); ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php $i++; endif; ?>
            <?php endforeach; ?>

            <?php foreach ($future_babies as $k => $future_baby): ?>
            <div class="family-member futbab" id="future-baby-<?=($k+1)?>"<?=($future_baby === null)?' style="display:none;"':'' ?>>
                <input type="hidden" value="<?=($future_baby === null)?'':$future_baby->id ?>" class="baby-id">

                <?php if ($k == 0): ?>
                    <div class="member-title">
                        <?php if ($future_baby !== null): ?>
                            <?=($future_baby->type == Baby::TYPE_WAIT) ? '<i class="icon-waiting"></i> Ждём' : 'Планируем'?><?php if ($user->hasBaby()): ?> ещё<?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="data clearfix">
                    Пол будущего ребенка:
                    <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 1)" class="gender tooltip male<?=($future_baby !== null && $future_baby->sex == 1)?' active':'' ?>" title="Мальчик"></a>
                    <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 0)" class="gender tooltip female<?=($future_baby !== null && $future_baby->sex == 0)?' active':'' ?>" title="Девочка"></a>
                    <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 2)" class="gender tooltip question<?=($future_baby !== null && $future_baby->sex == 2)?' active':'' ?>" title="Не знаем"></a>

                </div>


                <?php if ($k == 0): ?>
                    <div class="data clearfix">

                        Приблизительная дата родов ребенка:

                        <div class="date"<?php if ($future_baby !== null && $future_baby->type == Baby::TYPE_PLANNING): ?> style="display:none;"<?php endif; ?>>

                            <div class="datepicker"<?php if ($future_baby !== null && $future_baby->birthday !== null): ?> style="display:none;"<?php endif; ?>>
                                        <span class="chzn-v2">
                                            <?php echo CHtml::dropDownList('baby_d_'.$i, ($future_baby !== null) ? $future_baby->getBDatePart('j') : '', array(''=>' ')+HDate::Days(), array(
                                            'class'=>'chzn w-1 date',
                                            'data-placeholder'=>' '
                                        )) ?>
                                        </span>
                                &nbsp;
                                        <span class="chzn-v2">
                                            <?php echo CHtml::dropDownList('baby_m_'.$i, ($future_baby !== null) ? $future_baby->getBDatePart('n') : '', array(''=>' ')+HDate::ruMonths(), array(
                                            'class'=>'chzn w-2 month',
                                            'data-placeholder'=>' '
                                        )) ?>
                                        </span>
                                &nbsp;
                                        <span class="chzn-v2">
                                            <?php echo CHtml::dropDownList('baby_y_'.$i, ($future_baby !== null) ? $future_baby->getBDatePart('Y') : '', array(''=>' ')+HDate::Range(date('Y'), date('Y') + 5), array(
                                            'class'=>'chzn w-3 year',
                                            'data-placeholder'=>' '
                                        )) ?>
                                        </span>
                                &nbsp;
                                <button class="btn btn-green-small" onclick="Family.saveBabyDate(this, true)"><span><span>Ok</span></span></button>
                            </div>

                            <div class="dateshower"<?php if ($future_baby === null || $future_baby->birthday === null): ?> style="display:none;"<?php endif; ?>>
                                <div class="text"><span class="age"><?=($future_baby === null) ? '' : $future_baby->birthday?></span>&nbsp;<a href="javascript:void(0);" onclick="Family.editDate(this);" class="edit tooltip" title="Редактировать имя"></a></div>
                            </div>

                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($k == 0): ?>
                    <p class="double"<?php if ($future_babies[1] !== null): ?> style="display: none;"<?php endif; ?>><a href="javascript:void(0)" onclick="$(this).parent().hide(); $('#future-baby-2').show();" class="couple"></a> Нажмите "+" если двойня</p>
                <?php endif; ?>

                <!--<div class="data clearfix">
                    Пол и дата рождения ребенка:
                    <a href="javascript:void(0);" class="gender male active"><span class="tip">Мальчик</span></a>
                    <a href="javascript:void(0);" class="gender female"><span class="tip">Девочка</span></a>
                    <div class="date">
                        <div class="text">18 недель <a href="javascript:void(0);" class="edit tooltip" title="Редактировать дату"></a></div>
                    </div>
                </div>

                <p><a href="" class="couple"></a> Нажмите "+" если двойня</p>-->
            </div>
            <?php endforeach; ?>

            <?php for ($i = $user->babyCount()+1; $i < 10; $i++): ?>
                <?php $this->renderPartial('_empty_child', array('i'=>$i)); ?>
            <?php endfor; ?>

        </div>

    </div>

</div>

<?php
    if (Yii::app()->user->id == $this->user->id) {
        $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
        $remove_tmpl->registerTemplates();
        $this->endWidget();
    }
?>

<script id="photoTmpl" type="text/x-jquery-tmpl">
    <li>
        <div class="img">
            <a href="javascript:void(0)" data-id="${id}">
                <img src="${img}" alt="">
                <span class="btn">Посмотреть</span>
            </a>
            <div class="actions">
                <a class="edit fancy tooltip" href="/albums/updatePhoto/?id=${id}"></a>
                <a class="remove" onclick="return RemoveWidget.removeConfirm(this, true, 'AlbumPhoto', ${id}, 'Album.removePhoto', ['эту&lt;br&gt;фотографию','Фотография успешно удалена']);" href="#"><i class="icon"></i></a>
            </div>
        </div>
    </li>
</script>

<script id="babyRadioTmpl" type="text/x-jquery-tmpl">
    <div class="radio-label" onclick="Family.setBaby(this, ${n});"><span>${n}</span><input type="radio" name="radio-3"></div>
</script>