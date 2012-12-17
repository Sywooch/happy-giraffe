<?php if ($recipe->ingredients): ?>
<div class="nutrition">

    <div class="block-title">Калорийность блюда</div>

    <div class="portion">
        <a onclick="toggleNutrition(this, 'g100');" href="javascript:void(0)" class="active">На 100 г.</a>
        |
        <?php if ($recipe->servings !== null): ?>
        <a onclick="toggleNutrition(this, 'total');" href="javascript:void(0)">На порцию</a>
        <?php else: ?>
        <a class="disabled" href="javascript:void(0)">На порцию</a>
        <?php endif; ?>
    </div>

    <ul class="g100">
        <li class="n-calories">
            <div class="icon">
                <i>К</i>
                Калории
            </div>
            <span class="calories"><?=$recipe->getNutritionalsPer100g(1)?></span> <span class="gray">ккал.</span>
        </li>
        <li class="n-protein">
            <div class="icon">
                <i>Б</i>
                Белки
            </div>
            <span class="protein"><?=$recipe->getNutritionalsPer100g(3)?></span> <span class="gray">г.</span>
        </li>
        <li class="n-fat">
            <div class="icon">
                <i>Ж</i>
                Жиры
            </div>
            <span class="fat"><?=$recipe->getNutritionalsPer100g(2)?></span> <span class="gray">г.</span>
        </li>
        <li class="n-carbohydrates">
            <div class="icon">
                <i>У</i>
                Углеводы
            </div>
            <span class="carbohydrates"><?=$recipe->getNutritionalsPer100g(4)?></span> <span class="gray">г.</span>
        </li>

    </ul>

    <?php if ($recipe->servings !== null): ?>
    <ul class="total" style="display:none;">
        <li class="n-calories">
            <div class="icon">
                <i>К</i>
                Калории
            </div>
            <span class="calories"><?=$recipe->getNutritionalsPerServing(1)?></span> <span class="gray">ккал.</span>
        </li>
        <li class="n-protein">
            <div class="icon">
                <i>Б</i>
                Белки
            </div>
            <span class="protein"><?=$recipe->getNutritionalsPerServing(3)?></span> <span class="gray">г.</span>
        </li>
        <li class="n-fat">
            <div class="icon">
                <i>Ж</i>
                Жиры
            </div>
            <span class="fat"><?=$recipe->getNutritionalsPerServing(2)?></span> <span class="gray">г.</span>
        </li>
        <li class="n-carbohydrates">
            <div class="icon">
                <i>У</i>
                Углеводы
            </div>
            <span class="carbohydrates"><?=$recipe->getNutritionalsPerServing(4)?></span> <span class="gray">г.</span>
        </li>

    </ul>
    <?php endif; ?>

</div>
<?php endif; ?>