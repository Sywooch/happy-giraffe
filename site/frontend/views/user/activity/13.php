<?php
    Yii::import('application.modules.cook.models.*');
    $recipe = new CookRecipe;
    $recipe->setAttributes($action->data, false);
?>

<div class="user-post list-item">

    <div class="box-title">Добавил кулинарный рецепт</div>

    <ul>
        <li>
            <div class="item-title"><?=CHtml::link($recipe->title, $recipe->url)?></div>
            <div class="added-date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $recipe->created)?></div>
            <?php if ($action->data['image'] !== false): ?>
                <div class="img">
                    <?=CHtml::link(CHtml::image($action->data['image']), $recipe->url)?>
                </div>
            <?php endif; ?>
        </li>
    </ul>

</div>