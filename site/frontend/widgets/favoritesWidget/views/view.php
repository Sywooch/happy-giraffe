<div class="redactor-panel">
    <input type="hidden" name="entity_id" value="<?=$model->primaryKey ?>" class="entity_id">
    <input type="hidden" name="entity" value="<?=get_class($model) ?>" class="entity">

    <?php if (get_class($model) == 'SimpleRecipe' || get_class($model) == 'MultivarkaRecipe'): ?>
        <a class="ico-redactor ico-redactor__social js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::BLOCK_SOCIAL_NETWORKS)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 7);return false;" title="Посты в соцсети"></a>

    <?php else: ?>

        <a class="ico-redactor ico-redactor__interest js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::BLOCK_INTERESTING)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 2);return false;" title="На главную"></a>

        <a class="ico-redactor ico-redactor__social js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::BLOCK_SOCIAL_NETWORKS)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, 7);return false;" title="Посты в соцсети"></a>

        <a class="ico-redactor ico-redactor__mail js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::WEEKLY_MAIL)) echo ' active'; ?>" href="#"
           onclick="Favourites.toggle(this, <?=Favourites::WEEKLY_MAIL ?>);return false;" title="Посты в рассылку"></a>

    <?php endif; ?>
</div>