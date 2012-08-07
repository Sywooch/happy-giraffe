<div class="col-1">

    <?php $this->renderPartial('_userinfo', array('user' => $this->user)); ?>

</div>

<div class="col-23 clearfix">

    <div class="content-title-new">Мои клубы</div>

    <div class="clubs clearfix">

        <ul>
            <?php foreach ($this->user->communities as $c): ?>
            <li class="club-img <?=$c->css_class ?>">
                <a href="<?php echo $c->url; ?>">
                    <img src="/images/club_img_<?php echo $c->position; ?>.png" />
                    <?php echo $c->title; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

    </div>

</div>