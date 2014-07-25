<?php
/**
 * @var HActiveRecord $data
 */
$full = false;
?>

<?php if ($data instanceof CommunityContent): ?>
    <?php $this->renderPartial('site.frontend.modules.blog.views.default.view', compact('data', 'full')); ?>
<?php endif; ?>

<?php if ($data instanceof CookRecipe): ?>
    <?php $this->renderPartial('site.frontend.modules.cook.views.recipe._recipe', compact('data')); ?>
<?php endif; ?>