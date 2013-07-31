<div class="club-list clearfix">
    <div class="clearfix">
        <span class="heading-small">Мои клубы <span class="color-gray">(16)</span> </span>
    </div>
    <ul class="club-list_ul clearfix">
        <?php foreach ($communities as $c): ?>
            <li class="club-list_li">
                <a href="<?=$c->url ?>" class="club-list_i">
                    <span class="club-list_img-hold">
                        <img src="/images/club/<?=$c->position ?>.png" alt="" class="club-list_img">
                    </span>
                    <span class="club-list_i-name"><?=$c->title ?></span>
                </a>
                <a href="" class="club-list_check powertip"></a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
