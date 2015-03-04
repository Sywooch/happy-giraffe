<?php if ($index == 0): ?>
    <?php $this->widget('site\frontend\modules\comments\modules\contest\widgets\ProfileWidget', array(
        'userId' => $user->id,
    )); ?>
<?php endif; ?>
<?php $this->renderPartial('site.frontend.modules.posts.views.list._view', compact('data')); ?>