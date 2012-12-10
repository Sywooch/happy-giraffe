<div class="clubs-list">
    <ul>
        <?php foreach ($data->clubs as $c): ?>
            <li class="club-img <?=$c->css_class?>">
                <a href="<?=$c->url?>">
                    <img src="/images/club_img_<?=$c->id?>.png">
                    <?=$c->title?>
                </a>
                <a href="<?=$c->url?>" class="club-join">Вступить</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>