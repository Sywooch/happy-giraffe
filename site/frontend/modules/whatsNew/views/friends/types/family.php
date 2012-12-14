<div class="textalign-c clearfix">
    <a href=""><img src="/images/user-family.png" alt="" /></a>
</div>
<div class="masonry-news-list_content">

    <div class="user-family">
        <ul>
            <?php if ($data->partner !== null && ! empty($data->partner->name)): ?>
                <li>
                    <big><?= $data->partner->name ?> <small>- <?php echo $data->user->getPartnerTitleOf(null, 3) ?></small></big>
                    <?php if (!empty($data->partner->notice)):?>
                    <div class="comment">
                        <?= $data->partner->notice ?>
                        <span class="tale"></span>
                    </div>
                    <?php endif ?>
                    <?php if (count($data->partner->photos) != 0):?>
                    <div class="img">
                        <img src="<?php echo $data->partner->getRandomPhotoUrl() ?>">
                    </div>
                    <?php endif ?>
                </li>
            <?php endif ?>

            <?php foreach ($data->babies as $baby): ?>
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

            <?php foreach ($data->babies as $baby): ?>
                <?php if ($baby->type == Baby::TYPE_WAIT): ?>
                    <li class="waiting clearfix">
                        <i class="icon"></i>
                        <div class="in">
                            <big>Ждём<?php if ($data->user->hasBaby()): ?> ещё<?php endif; ?></big>
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


        <?php if ($album = $data->user->getSystemAlbum(3) && ! empty($album->photos)): ?>
            <?=CHtml::link('Смотреть семейный<br/>альбом', $album->url, array('class' => 'watch-album'))?>
        <?php endif; ?>
    </div>

</div>