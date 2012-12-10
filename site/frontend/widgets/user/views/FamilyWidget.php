<?php
    $border = UserAttributes::get($user->id, 'familyBorder', 0);
    //$this->user->babies = Baby::model()->with(array('photos'))->findAll('parent_id = '.$this->user->id);
?>

<?php if (($user->babyCount() > 0) || ($user->hasPartner() && !empty($user->partner->name)) || $this->showEmpty):?>
<div class="user-family user-family-border-<?=$border?>" data-family-border="<?=$border?>">
    <div class="t"></div>
    <div class="c">
        <ul>
            <?php if ($user->hasPartner() && !empty($user->partner->name)): ?>
            <li>
                <big><?= $user->partner->name ?> <small>- <?php echo $user->getPartnerTitleOf(null, 3) ?></small></big>
                <?php if (!empty($user->partner->notice)):?>
                    <div class="comment">
                        <?= $user->partner->notice ?>
                        <span class="tale"></span>
                    </div>
                <?php endif ?>
                <?php if (count($user->partner->photos) != 0):?>
                <div class="img">
                    <img src="<?php echo $user->partner->getRandomPhotoUrl() ?>">
                </div>
                <?php endif ?>
            </li>
            <?php endif ?>
            <?php foreach ($user->babies as $baby): ?>
                <?php if (empty($baby->type)):?>
                    <li>
                        <big><?php echo $baby->name ?> <small>- <?=($baby->sex) ? 'мой сын' : 'моя дочь'?><?php if (!empty($baby->birthday)) echo ', '.$baby->getTextAge(false) ?></small></big>
                        <?php if (!empty($baby->notice)):?>
                        <div class="comment">
                            <?= $baby->notice ?>
                            <span class="tale"></span>
                        </div>
                        <?php endif ?>

                        <?php if (count($baby->photos) != 0):?>
                            <div class="img">
                                <img src="<?php echo $baby->getRandomPhotoUrl() ?>">
                            </div>
                        <?php endif ?>
                    </li>
                <?php endif ?>
            <?php endforeach; ?>

            <?php foreach ($user->babies as $baby): ?>
                <?php if ($baby->type == Baby::TYPE_WAIT): ?>
                    <li class="waiting clearfix">
                        <i class="icon"></i>
                        <div class="in">
                            <big>Ждём<?php if ($user->hasBaby()): ?> ещё<?php endif; ?></big>
                            <?php if ($baby->sex == 0): ?>
                                <div class="gender">Девочку <i class="icon-female"></i></div>
                            <?php endif; ?>
                            <?php if ($baby->sex == 1): ?>
                                <div class="gender">Мальчика <i class="icon-male"></i></div>
                            <?php endif; ?>
                            <?php if ($baby->sex == 2): ?>
                                <div class="gender">Не знаем <i class="icon-question"></i></div>
                            <?php endif; ?>
                            <?php if ($baby->birthday): ?>
                                <?php
                                    $now = new DateTime();
                                    $birthday = new DateTime($baby->birthday);
                                    $conception = clone $birthday;
                                    $conception->modify('-9 month');
                                    $interval = $now->diff($conception);
                                    $week = ceil($interval->days / 7);
                                ?>
                                <?php if ($week <= 40): ?><div class="time"><?=$week?>-я неделя</div><?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>

        </ul>

        <?php if ($album = $user->getSystemAlbum(3) && ! empty($album->photos)): ?>
            <?=CHtml::link('Смотреть семейный<br/>альбом', $album->url, array('class' => 'watch-album'))?>
        <?php endif; ?>
        <?php if ($this->isMyProfile && $user->hasFeature(1)): ?>
            <div class="user-family-settings clearfix">
                <div class="a-right tooltip-new">9 новых</div>
                <a class="a-right pseudo" href="javascript:void(0)" onclick="$('.user-family-borders').toggle();">Стиль рамок</a>
            </div>
        <?php endif; ?>
    </div>
    <div class="b"></div>
</div>

    <?php if ($this->isMyProfile && $user->hasFeature(1)): ?>
        <div class="user-family-borders" style="display: none;">
            <p>Выберите стиль рамки</p>
            <ul class="pattern-list clearfix">
                <?php for ($i = 0; $i <= 8; $i++): ?>
                    <li><a href="javascript:void(0)" onclick="Features.selectFeature('familyBorder', <?=$i?>, function(){Features.familyBorder(<?=$i?>)})"<?php if ($border == $i): ?> class="active"<?php endif; ?>><span class="pattern user-family-border-<?=$i?>"></span></a></li>
                <?php endfor; ?>
            </ul>
        </div>
    <?php endif; ?>
<?php else: ?>
<?php if ($this->user->relationship_status == 0 && $this->isMyProfile && $user->babyCount() == 0): ?>
    <div class="user-family user-family-cap">
        <div class="t"></div>
        <div class="c">
            <a href="<?=Yii::app()->createUrl('/family') ?>" class="cap"><span>Расскажите<br>о своей семье</span></a>
        </div>
        <div class="b"></div>
    </div>
    <?php endif ?>
<?php endif ?>