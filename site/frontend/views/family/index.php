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
';

$basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);

Yii::app()->clientScript->registerScript('family-edit',$js)
    ->registerScriptFile($baseUrl. '/family.js?r=34', CClientScript::POS_HEAD);

?>
<div class="user-cols clearfix">

    <div class="col-1">
        <?php $this->widget('application.widgets.user.FamilyWidget', array('user' => $user, 'showEmpty'=>true)); ?>
    </div>

    <div class="col-23 clearfix">

    <div class="user-top-block clearfix" style="margin-bottom: 10px;height: auto;">

        <?php $showFamily = true;$this->renderPartial('//user/_user_menu',compact('user', 'showFamily')); ?>

    </div>

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

                <div class="family-member" id="user-partner"<?php if (!$user->hasPartner()) echo ' style="display:none;"' ?>>

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

                        <div<?php if (empty($user->partner->name)) echo ' style="display:none;"' ?>>
                            <a href="javascript:void(0);" onclick="Family.editPartnerNotice(this)" class="comment tooltip" title="Расскажите о <?= ($user->gender == 1)?'ней':'нем' ?>"></a>
                            <a href="javascript:void(0);" class="photo tooltip" title="Добавить 4 фото">
                                <?php $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'partner_photo_upload2',
                                    'action' => $this->createUrl('uploadPhoto'),
                                    'htmlOptions' => array(
                                        'enctype' => 'multipart/form-data',
                                    ),
                                )); ?>
                                <?php echo CHtml::fileField('partner-photo', '', array('class'=>'partner-photo-file')); ?>
                                <?php $this->endWidget(); ?>
                            </a>
                        </div>
                    </div>

                    <div class="comment"<?php if (empty($user->partner->notice)) echo ' style="display:none;"' ?>>
                        <div class="input" style="display:none;">
                            <div class="tale"></div>
                            <textarea><?=$user->partner->notice ?></textarea>
                            <button class="btn btn-green-small" onclick="Family.savePartnerNotice(this)"><span><span>Ok</span></span></button>
                        </div>
                        <div class="text"><span class="text"><?=$user->partner->notice ?></span> <a href="javascript:void(0);" onclick="Family.editPartnerNotice(this)" class="edit tooltip" title="Редактировать комментарий"></a></div>
                    </div>

                    <div class="photos"<?php if (count($user->partner->photos) == 0) echo ' style="display:none;"' ?>>

                        <ul>
                            <?php foreach ($user->partner->photos as $photo): ?>
                            <li>
                                <img src="<?=$photo->photo->getPreviewUrl(180, 180) ?>" alt="">
                                <?php echo CHtml::hiddenField('id', $photo->id); ?>
                                <a href="" class="remove"></a>
                            </li>
                            <?php endforeach; ?>

                            <li class="add"<?php if (count($user->partner->photos) == 4) echo ' style="display:none;"' ?>>
                                <a href="javascript:void(0);" class="fake_file">

                                    <i class="icon"></i>
                                    <span>Загрузить еще<br> <ins><?=4 - count($user->partner->photos) ?></ins> <span>фотографи<?= (count($user->partner->photos) == 3)?'ю':'и' ?></span></span>
                                    <?php $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'partner_photo_upload1',
                                    'action' => $this->createUrl('uploadPhoto'),
                                    'htmlOptions' => array(
                                        'enctype' => 'multipart/form-data',
                                    ),
                                )); ?>
                                    <?php echo CHtml::fileField('partner-photo', '', array('class'=>'partner-photo-file')); ?>
                                    <?php $this->endWidget(); ?>
                                </a>

                            </li>
                        </ul>

                    </div>

                </div>

            <br>

            <div class="family-radiogroup">
                <div class="title">Мои дети</div>
                <div class="radiogroup">
                    <div class="radio-label<?php if($user->hasBaby(Baby::TYPE_PLANNING) == 1) echo ' checked'?>" onclick="Family.setFutureBaby(this, <?=Baby::TYPE_PLANNING ?>);"><span>Планируем</span><input type="radio" name="radio-2"></div>
                    <div class="radio-label<?php if($user->hasBaby(Baby::TYPE_WAIT) == 1) echo ' checked'?>" onclick="Family.setFutureBaby(this, <?=Baby::TYPE_WAIT ?>);"><span>Ждем</span><input type="radio" name="radio-2"></div>
                </div>
                &nbsp;
                <div class="radiogroup">
                    <div class="radio-label<?php if($user->babyCount() == 1) echo ' checked'?>" onclick="Family.setBaby(this, 1);"><span>1 ребенок</span><input type="radio" name="radio-3"></div>
                    <div class="radio-label<?php if($user->babyCount() == 2) echo ' checked'?>" onclick="Family.setBaby(this, 2);"><span>2 ребенка</span><input type="radio" name="radio-3"></div>
                    <div class="radio-label<?php if($user->babyCount() == 3) echo ' checked'?>" onclick="Family.setBaby(this, 3);"><span>3 ребенка</span><input type="radio" name="radio-3"></div>
                    <div class="radio-label<?php if($user->babyCount() == 4) echo ' checked'?>" onclick="Family.setBaby(this, 4);"><span>4 ребенка</span><input type="radio" name="radio-3"></div>
                </div>
            </div>

            <div class="family-member" id="future-baby"<?=($future_baby === null)?' style="display:none;"':'' ?>>
                <input type="hidden" value="<?=($future_baby === null)?'':$future_baby->id ?>" class="baby-id">

                <div class="data clearfix">
                    <?php if ($future_baby !== null){
                        $text = ($future_baby->type == 1)?'Кого ждем:':'Кого планируем:';
                    }else
                        $text = '';
                    ?>
                    <div class="d-text"><?=$text ?></div>

                    <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 1)" class="gender tooltip male<?=($future_baby !== null && $future_baby->sex == 1)?' active':'' ?>" title="Мальчик"></a>
                    <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 0)" class="gender tooltip female<?=($future_baby !== null && $future_baby->sex == 0)?' active':'' ?>" title="Девочка"></a>
                    <a href="javascript:void(0);" onclick="Family.saveBabyGender(this, 2)" class="gender tooltip question<?=($future_baby !== null && $future_baby->sex == 2)?' active':'' ?>" title="Не знаем"></a>

                </div>

            </div>



            <?php $i=1; foreach ($user->babies as $baby): ?>
                <?php if (empty($baby->type)):?>
                    <div class="family-member" id="baby-<?=$i ?>">
                        <input type="hidden" value="<?=$baby->id ?>" class="baby-id">
                        <div class="data clearfix">
                            <div class="d-text">Имя <?=$i ?>-го ребенка:</div>

                            <div class="name">
                                <div class="text"<?php if (empty($baby->name)) echo ' style="display:none;"' ?>><?=$baby->name ?></div>
                                <div class="input"<?php if (!empty($baby->name)) echo ' style="display:none;"' ?>>
                                    <input type="text">
                                    <button class="btn btn-green-small" onclick="Family.saveBabyName(this);"><span><span>Ok</span></span></button>
                                </div>
                                <a href="javascript:void(0);" onclick="Family.editBabyName(this)" class="edit tooltip"<?php if (empty($baby->name)) echo ' style="display:none;"' ?> title="Редактировать имя"></a>
                            </div>

                            <div<?php if (empty($baby->name)) echo ' style="display:none;"' ?> class="hide-on-start">
                                <a href="javascript:void(0);" class="gender tooltip male<?php if ($baby->sex == 1) echo ' active'?>" onclick="Family.saveBabyGender(this, 1)" title="Мальчик"></a>
                                <a href="javascript:void(0);" class="gender tooltip female<?php if ($baby->sex == 0) echo ' active'?>" onclick="Family.saveBabyGender(this, 0)" title="Девочка"></a>

                                <div<?php if ($baby->sex === null) echo ' style="display:none;"' ?> class="hide-on-start">
                                    <div class="age">
                                        <?= $baby->getTextAge() ?>
                                    </div>
                                    <div class="date">
                                        <a href="javascript:void(0);" onclick="Family.editDate(this);" class="date tooltip" title="Укажите дату рождения"></a>
                                        <div class="datepicker" style="display:none;">
                                            <div class="tale"></div>
                                            <?php echo CHtml::dropDownList('baby_d_'.$i, $baby->getBDatePart('j'), array(''=>' ')+HDate::Days(), array(
                                            'class'=>'chzn w-50 date',
                                            'data-placeholder'=>' '
                                        )) ?>
                                            &nbsp;
                                            <?php echo CHtml::dropDownList('baby_m_'.$i, $baby->getBDatePart('n'), array(''=>' ')+HDate::ruMonths(), array(
                                            'class'=>'chzn w-100 month',
                                            'data-placeholder'=>' '
                                        )) ?>
                                            &nbsp;
                                            <?php echo CHtml::dropDownList('baby_y_'.$i, $baby->getBDatePart('Y'), array(''=>' ')+HDate::Range(date('Y'), date('Y') - 50), array(
                                            'class'=>'chzn w-50 year',
                                            'data-placeholder'=>' '
                                        )) ?>
                                            &nbsp;
                                            <button class="btn btn-green-small" onclick="Family.saveBabyDate(this)"><span><span>Ok</span></span></button>
                                        </div>
                                    </div>

                                    <a href="javascript:void(0);" onclick="Family.editBabyNotice(this)" class="comment tooltip" title="Расскажите о нем"></a>
                                    <a href="javascript:void(0);" class="photo tooltip" title="Добавить 4 фото">
                                        <?php $form = $this->beginWidget('CActiveForm', array(
                                            'id' => 'baby_photo_upload2'.$i,
                                            'action' => $this->createUrl('uploadBabyPhoto'),
                                            'htmlOptions' => array(
                                                'enctype' => 'multipart/form-data',
                                                'class'=>'baby_photo_upload',
                                            ),
                                        )); ?>
                                        <?php echo CHtml::hiddenField('baby_id', $baby->id,array('id'=>'baby_id'.$i, 'class'=>'baby_id_2')); ?>
                                        <?php echo CHtml::fileField('baby-photo','', array('id'=>'baby-photo'.$i, 'class'=>'baby-photo-file')); ?>
                                        <?php $this->endWidget(); ?>

                                    </a>

                                </div>
                            </div>
                        </div>

                        <div class="comment"<?php if (empty($baby->notice)) echo ' style="display:none;"' ?>>
                            <div class="input" style="display:none;">
                                <div class="tale"></div>
                                <textarea><?=$baby->notice ?></textarea>
                                <button class="btn btn-green-small" onclick="Family.saveBabyNotice(this)"><span><span>Ok</span></span></button>
                            </div>
                            <div class="text"><span class="text"><?=$baby->notice ?></span> <a href="javascript:void(0);" onclick="Family.editBabyNotice(this)" class="edit tooltip" title="Редактировать комментарий"></a></div>
                        </div>

                        <div class="photos"<?php if (count($baby->photos) == 0) echo ' style="display:none;"' ?>>

                            <ul>
                                <?php foreach ($baby->photos as $photo): ?>
                                <li>
                                    <img src="<?=$photo->photo->getPreviewUrl(180, 180) ?>" alt="">
                                    <?php echo CHtml::hiddenField('id', $photo->id); ?>
                                    <a href="" class="remove"></a>
                                </li>
                                <?php endforeach; ?>

                                <li class="add"<?php if (count($baby->photos) == 4) echo ' style="display:none;"' ?>>
                                    <a href="javascript:void(0);" class="fake_file">

                                        <i class="icon"></i>
                                        <span>Загрузить еще<br> <ins><?=4 - count($baby->photos) ?></ins> <span>фотографи<?= (count($baby->photos) == 3)?'ю':'и' ?></span></span>

                                        <?php $form = $this->beginWidget('CActiveForm', array(
                                        'id' => 'baby_photo_upload1'.$i,
                                        'action' => $this->createUrl('uploadBabyPhoto'),
                                        'htmlOptions' => array(
                                            'enctype' => 'multipart/form-data',
                                            'class'=>'baby_photo_upload',
                                        ),
                                    )); ?>
                                        <?php echo CHtml::hiddenField('baby_id', $baby->id,array('id'=>'baby_id'.$i, 'class'=>'baby_id_2')); ?>
                                        <?php echo CHtml::fileField('baby-photo','', array('id'=>'baby-photo'.$i, 'class'=>'baby-photo-file')); ?>
                                        <?php $this->endWidget(); ?>
                                    </a>

                                </li>
                            </ul>

                        </div>

                    </div>
                    <?php $i++; ?>
                    <?php endif ?>
            <?php endforeach; ?>

            <?php while($i <= 4){ ?>
            <div class="family-member" style="display:none;" id="baby-<?=$i ?>">
                <?php $this->renderPartial('_empty_child',array('i'=>$i)); ?>
            </div>
            <?php $i++; ?>
            <?php } ?>
        </div>

    </div>

</div>