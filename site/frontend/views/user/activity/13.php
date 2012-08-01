<?php
    Yii::import('application.modules.cook.models.*');
    $recipe = new CookRecipe;
    $recipe->setAttributes($action->data, false);
?>

<div class="user-post list-item">

    <div class="box-title"><?=($users[$action->user_id]->gender == 1) ? 'Добавил' : 'Добавила'?> кулинарный рецепт</div>

    <ul>
        <li>
            <div class="item-title"><?=CHtml::link($recipe->title, $recipe->url)?></div>
            <div class="added-date"><?=Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $recipe->created)?></div>
            <?php if ($action->data['contentImage'] !== false): ?>
                <div class="img">
                    <?=CHtml::link(CHtml::image($action->data['contentImage']), $recipe->url)?>
                </div>
            <?php endif; ?>
        </li>
    </ul>

</div>