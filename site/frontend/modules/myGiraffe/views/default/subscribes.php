<ul class="breadcrumbs-big clearfix">
    <li class="breadcrumbs-big_i">
        <a href="/my/" class="breadcrumbs-big_a">Мой Жираф</a>
    </li>
    <li class="breadcrumbs-big_i">Мои подписки</li>
</ul>
<div class="col-gray padding-20 clearfix">

    <div class="clearfix">
        <span class="i-highlight i-highlight__big font-big">Мои клубы</span>
    </div>

    <?php $this->widget('ClubsWidget', array('user' => Yii::app()->user->getModel(), 'size' => 'Big')); ?>

    <div class="clearfix">
        <span class="i-highlight i-highlight__big font-big">Мои подписки на блоги</span>
    </div>

    <?php foreach ($blog_subscriptions as $blog_subscription)
        $this->renderPartial('_blog', array('user' => $blog_subscription)); ?>

</div>