<div class="admin-buttons">
    <input type="hidden" name="entity_id" value="<?=$model->primaryKey ?>" class="entity_id">
    <input type="hidden" name="entity" value="<?=get_class($model) ?>" class="entity">

    <?php if (get_class($model) == 'User'): ?>
        <a class="tooltip purple add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::BLOCK_SIMPLE)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 1);return false;" title="Поместить на главную страницу">Г</a>

    <?php endif; ?>

    <?php if (get_class($model) == 'BlogContent'): ?>
        <a class="tooltip orange add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::BLOCK_INTERESTING)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 2);return false;" title="Поместить в Самые интересные">И</a>

        <a class="tooltip green add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::BLOCK_BLOGS)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 3);return false;" title="Поместить в Блоги">Б</a>

        <a class="tooltip green add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::BLOCK_SOCIAL_NETWORKS)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 7);return false;" title="Поместить в Соц Сети">S</a>

        <a class="tooltip mailer add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::WEEKLY_MAIL)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, <?=Favourites::WEEKLY_MAIL ?>);return false;" title="Поместить в рассылку">Р</a>
        <a href="/community/weeklyMail/" target="_blank" style="border:none;color:#333 !important;">все</a>

    <?php endif; ?>

    <?php if (get_class($model) == 'CommunityContent'): ?>
        <a class="tooltip orange add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::BLOCK_INTERESTING)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 2);return false;" title="Поместить в Самые интересные">И</a>

        <a class="tooltip green add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::BLOCK_SOCIAL_NETWORKS)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 7);return false;" title="Поместить в Соц Сети">S</a>

    <a class="tooltip mailer add-to-favourites<?php if (Favourites::inFavourites($model, Favourites::WEEKLY_MAIL)) echo ' active'; ?>" href="#"
       onclick="Favourites.toggle(this, <?=Favourites::WEEKLY_MAIL ?>);return false;" title="Поместить в рассылку">Р</a>
    <a href="/community/weeklyMail/" target="_blank" style="border:none;color:#333 !important;">все</a>

    <?php endif; ?>

</div>