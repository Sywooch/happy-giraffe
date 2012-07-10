<div class="admin-buttons">
    <input type="hidden" name="entity_id" value="<?=$model->primaryKey ?>" class="entity_id">
    <input type="hidden" name="entity" value="<?=get_class($model) ?>" class="entity">

    <?php if (get_class($model) == 'User'): ?>
        <a class="tooltip purple add-to-favourites<?php if (Favourites::inFavourites($model, 1)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 1);return false;" title="Поместить на главную страницу">Г</a>

    <?php endif; ?>

    <?php if (get_class($model) == 'BlogContent'): ?>
        <a class="tooltip orange add-to-favourites<?php if (Favourites::inFavourites($model, 2)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 2);return false;" title="Поместить в Самые интересные">И</a>

        <a class="tooltip green add-to-favourites<?php if (Favourites::inFavourites($model, 3)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 3);return false;" title="Поместить в Блоги">Б</a>

        <?php if ($model->type_id == 2): ?>
            <a class="tooltip lilac add-to-favourites<?php if (Favourites::inFavourites($model, 5)) echo ' active'; ?>" href="#"
               onclick="Favourites.toggle(this, 5);return false;" title="Поместить в Видео Дня">В</a>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (get_class($model) == 'CommunityContent'): ?>
        <a class="tooltip orange add-to-favourites<?php if (Favourites::inFavourites($model, 2)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 2);return false;" title="Поместить в Самые интересные">И</a>

        <?php if ($model->rubric->community_id == 26): ?>
            <a class="tooltip blue add-to-favourites<?php if (Favourites::inFavourites($model, 4)) echo ' active'; ?>" href="#"
               onclick="Favourites.toggle(this, 4, 26);return false;" title="Поместить в Дизайн">Д</a>
        <?php endif; ?>

        <?php if ($model->rubric->community_id == 22): ?>
            <a class="tooltip yellow add-to-favourites<?php if (Favourites::inFavourites($model, 4)) echo ' active'; ?>" href="#"
               onclick="Favourites.toggle(this, 4, 22);return false;" title="Поместить в Кулинарию">К</a>
        <?php endif; ?>

        <?php if ($model->type_id == 2): ?>
            <a class="tooltip lilac add-to-favourites<?php if (Favourites::inFavourites($model, 5)) echo ' active'; ?>" href="#"
               onclick="Favourites.toggle(this, 5);return false;" title="Поместить в Видео Дня">В</a>
        <?php endif; ?>
    <?php endif; ?>
</div>