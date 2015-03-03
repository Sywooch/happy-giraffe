<?php $this->renderPartial('site.frontend.modules.posts.views.list._view', compact('data')); ?>

<?php if ($index == 1): ?>
    123
<?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\ProfileWidget', array(
        'userId' => $user->id,
    )); ?>
<?php endif; ?>