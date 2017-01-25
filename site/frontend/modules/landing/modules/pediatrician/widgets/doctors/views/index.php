<?php
/**
 * @var \site\frontend\modules\landing\modules\pediatrician\widgets\doctors\DoctorsWidget $this
 * @var \site\frontend\modules\users\models\User[] $users
 */
?>

<div class="landing__body landing-doctors textalign-c">
    <div class="font__title-xm font__bold">Здесь отвечают<br>сотни педиатров и 300 000 опытных мам</div>
    <ul class="landing-doctors__list">
        <?php foreach ($users as $user): ?>
        <li class="landing-doctors__li">
            <a href="/user/<?=$user->id?>" class="landing-doctors__link">
                <div class="b-ava-large b-ava-large__nohover margin-b0 margin-t0">
                    <div class="b-ava-large_ava-hold">
                        <span class="ava ava__large ava__<?=($user->gender == '1') ? 'male' : 'female'?>  ava__base-xs">
                            <img alt="" src="<?=$user->getAvatarUrl(Avatar::SIZE_LARGE)?>" class="ava_img">
                        </span>
                    </div>
                </div>
                <div class="landing-doctors__title font__title-sx"><?=$user->getFullName()?></div>
                <?php if ($user->specialistInfoObject->title): ?>
                    <div class="landing-doctors__descr font__title-sx"><?=$user->specialistInfoObject->title?></div>
                <?php endif; ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="textalign-c"><a href="#" class="btn btn-forum btn-success">Задать вопрос</a></div>
</div>