<?php
/* @var $this Controller
 * @var $data CookRecipe
 */
$users = $data->getBookedUsers();
$count = $data->getBookedCount();
?>
<div class="recipe-right">
    <div class="cook-book-info">
        <a href="javascript:;" onclick="Cook.bookRecipe(this)" data-id="<?=$data->id ?>">
            <?php if ($data->isBooked()):?>
                <span>Рецепт в моей <br>кулинарной книге</span>
                <i class="icon-exist"></i>
            <?php else: ?>
                <span>Добавить в мою <br>кулинарную книгу</span>
                <i class="icon-add"></i>
            <?php endif ?>
        </a>
    </div>
    <div class="recipe-user-adds">
        <?php if ($count == 0): ?>
        <?php else: ?>
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
                    <li><a href="" class="link-text">и еще <?=$$count - 20 ?></a></li>
                <?php endif ?>
            </ul>
        <?php endif ?>
    </div>

</div>