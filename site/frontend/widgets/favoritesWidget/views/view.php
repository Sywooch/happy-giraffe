<div class="admin-buttons">
    <input type="hidden" name="entity_id" value="<?=$model->primaryKey ?>" class="entity_id">
    <input type="hidden" name="entity" value="<?=get_class($model) ?>" class="entity">
    <?php if (get_class($model) == 'User'):?>
        <a class="purple add-to-favourites<?php if (Favourites::inFavourites($model, 1)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 1);return false;">Г<span class="tip">Поместить на главную страницу</span></a>

    <?php endif ?>
    <?php if (get_class($model) == 'BlogContent'):?>
        <a class="orange add-to-favourites<?php if (Favourites::inFavourites($model, 2)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 2);return false;">И<span class="tip">Поместить в Самые интересные</span></a>

        <a class="green add-to-favourites<?php if (Favourites::inFavourites($model, 3)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 3);return false;">Б<span class="tip">Поместить в Блоги</span></a>

    <?php endif ?>
    <?php if (get_class($model) == 'CommunityContent'):?>
    <a class="orange add-to-favourites<?php if (Favourites::inFavourites($model, 2)) echo ' active'; ?>" href="#"
       onclick="Favourites.toggle(this, 2);return false;">И<span class="tip">Поместить в Самые интересные</span></a>

        <?php if ($model->rubric->community_id == 26):?>
            <a class="blue add-to-favourites<?php if (Favourites::inFavourites($model, 4)) echo ' active'; ?>" href="#"
               onclick="Favourites.toggle(this, 4);return false;">Д<span class="tip">Поместить в Дизайн</span></a>

        <?php endif ?>
        <?php if ($model->rubric->community_id == 22):?>
            <a class="yellow add-to-favourites<?php if (Favourites::inFavourites($model, 4)) echo ' active'; ?>" href="#"
               onclick="Favourites.toggle(this, 4);return false;">К<span class="tip">Поместить в Кулинарию</span></a>

        <?php endif ?>
    <?php endif ?>
</div>