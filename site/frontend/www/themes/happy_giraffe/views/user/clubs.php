<div class="user-cols clearfix">

    <div class="col-1">
        &nbsp;
    </div>

    <div class="col-23 clearfix">

        <div class="content-title">Клубы</div>

        <div class="clubs clearfix">

            <ul>
                <?php foreach ($this->user->communities as $c): ?>
                    <li class="club-img kids">
                        <a href="<?php echo $c->url; ?>">
                            <img src="/images/club_img_<?php echo $c->position; ?>.png" />
                            <?php echo $c->name; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>


        </div>

    </div>

</div>