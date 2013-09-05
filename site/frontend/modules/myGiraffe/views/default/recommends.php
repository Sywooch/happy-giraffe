<ul class="breadcrumbs-big clearfix">
    <li class="breadcrumbs-big_i">
        <a href="/my/" class="breadcrumbs-big_a">Мой Жираф</a>
    </li>
    <li class="breadcrumbs-big_i">Рекомендация подписок</li>
</ul>

<div class="col-gray padding-20 clearfix">
    <?php if (!empty($clubs)): ?>
        <div class="clearfix">
            <span class="i-highlight i-highlight__big font-big">Рекомендуем вам вступить в клубы</span>
        </div>

        <?php $this->widget('ClubsWidget', array(
            'user' => Yii::app()->user->getModel(),
            'size' => 'Big',
            'clubs' => $clubs,
            'limit' => 8,
            'deleteClub' => true
        )); ?>
    <?php endif ?>

    <?php if (!empty($blog_subscriptions)): ?>
        <div class="clearfix">
            <span class="i-highlight i-highlight__big font-big">Рекомендуем вам подписаться на блоги</span>
        </div>

        <?php foreach ($blog_subscriptions as $blog_subscription)
            $this->renderPartial('_blog', array('user' => $blog_subscription)); ?>
    <?php endif ?>

</div>