<ul class="sidebar-promo-latest">
    <?php foreach ($models as $model) $this->widget('site\frontend\modules\posts\modules\contractubex\widgets\sidebarWidget\SidebarPostWidget', compact('model')); ?>
</ul>