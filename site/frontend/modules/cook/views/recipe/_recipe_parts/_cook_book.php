<?php
/* @var $this Controller
 * @var $recipe CookRecipe
 */
$users = $recipe->getBookedUsers();
$count = $recipe->getBookedCount();
?>
<div class="recipe-right">
    <div class="cook-book-info">
        <a <?= (Yii::app()->user->isGuest) ? 'href="#login" class="fancy"' : 'href="javascript:;"' ?>  onclick="Cook.bookRecipe(this)" data-id="<?=$recipe->id ?>" data-theme="white-square">
            <?php if ($recipe->isBooked()):?>
                <span>Рецепт в моей <br>кулинарной книге</span>
                <i class="icon-exist"></i>
            <?php else: ?>
                <span>Добавить в мою <br>кулинарную книгу</span>
                <i class="icon-add"></i>
            <?php endif ?>
        </a>
    </div>
    <?php if (count($users) > 0): ?>
        <div class="recipe-user-adds">
            <p>Этот рецепт также добавили:</p>
            <ul class="clearfix">
                <?php foreach ($users as $user): ?>
                    <li>
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                        'user' => $user,
                        'size' => 'small',
                        'small'=>true,
                        'hideLinks' => true)); ?>
                    </li>
                <?php endforeach; ?>
                <?php if ($count > 20): ?>
                    <li><span class="link-text">и еще <?=$count - 20 ?></span></li>
                <?php endif ?>
            </ul>
        </div>
    <?php endif ?>

</div>