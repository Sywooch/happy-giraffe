<?php if (!empty($recipe->servings)):?>
    <div class="cook-diabets">
        <div class="cook-diabets-chart <?=$recipe->getBakeryItemsCssClass() ?>">
            <span class="text"><?=$recipe->bakeryItems?></span>
        </div>
        <div class="cook-diabets-desc"><?=$recipe->getBakeryItemsText() ?></div>
    </div>
<?php endif ?>