<?php if ($recipe->cuisine || $recipe->preparation_duration || $recipe->cooking_duration || $recipe->servings): ?>
<div class="recipe-description clearfix">
    <div class="recipe-description-holder">
        <?php if ($recipe->cuisine): ?>
        <span class="country"><?php if (!empty($recipe->cuisine->country_id)):?><span class="flag-big flag-big-<?=$recipe->cuisine->country->iso_code ?>"></span><?php endif ?><?=$recipe->cuisine->title?></span>
        <?php endif; ?>
        <?php if ($recipe->preparation_duration): ?>
        <div class="recipe-description-item">
            <div class="icon-time-1 tooltip" title="Время подготовки"></div>
            <?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?>
        </div>
        <?php endif; ?>
        <?php if ($recipe->cooking_duration): ?>
        <div class="recipe-description-item">
            <div class="icon-time-2 tooltip" title="Время приготовления"></div>
            <?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?>
        </div>
        <?php endif; ?>
        <?php if ($recipe->servings): ?>
        <div class="recipe-description-item">
            <div class="icon-yield tooltip" title="Количество порций"></div>
            на <span class="yield"><?=$recipe->servings?></span> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>