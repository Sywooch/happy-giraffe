<div>
    <input type="hidden" name="entity_id" value="<?=$model->primaryKey ?>">
    <input type="hidden" name="entity" value="<?=get_class($model) ?>">
    <a class="add-to-favourites<?php if ($model->in_favourites) echo ' active'; ?>" href="#" onclick="ToggleFavourites(this);return false;">В избранные</a>
</div>
<style type="text/css">
    a.add-to-favourites{
        background: #fff;
        display: block;
        border: 1px solid #000;
    }
    a.add-to-favourites.active{
        background: #ffff00;
    }
</style>