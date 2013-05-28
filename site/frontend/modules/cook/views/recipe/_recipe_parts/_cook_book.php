<?php
/* @var $this Controller
 * @var $recipe CookRecipe
 */
$users = $recipe->getBookedUsers();
$count = $recipe->getBookedCount();
?>
<div class="recipe-right">
    <?php $this->widget('FavouriteWidget', array('model' => $recipe)); ?>
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