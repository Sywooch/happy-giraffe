<?php
/**
 * @var \site\frontend\modules\landing\modules\pediatrician\widgets\doctors\DoctorsWidget $this
 * @var \site\frontend\modules\specialists\models\SpecialistProfile[] $profiles
 */

?>

<div class="landing__body landing-doctors textalign-c">
    <div class="font__title-xm font__bold">Здесь отвечают<br>сотни педиатров и 300 000 опытных мам</div>
    <ul class="landing-doctors__list">
        <?php foreach ($profiles as $profile): ?>
        <li class="landing-doctors__li">
            <a href="/user/<?=$profile->id?>" class="landing-doctors__link">
                <div class="b-ava-large b-ava-large__nohover margin-b0 margin-t0">
                    <div class="b-ava-large_ava-hold">
                        <span class="ava ava__large ava__<?=($profile->user->gender == '1') ? 'male' : 'female'?>  ava__base-xs">
                            <img alt="" src="<?=$profile->user->getAvatarUrl(Avatar::SIZE_LARGE)?>" class="ava_img">
                        </span>
                    </div>
                </div>
                <div class="landing-doctors__title font__title-sx"><?=$profile->user->getFullName()?></div>
                <div class="landing-doctors__descr font__title-sx"><?=$profile->user->specialistInfoObject->title?></div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="textalign-c"><a href="#" class="btn btn-forum btn-success">Задать вопрос</a></div>
</div>