<div class="club-advices">
    <h1 class="club-advices_heading">Наши советы</h1>
    <ul class="club-advices_list">
    <?php foreach ($models as $model) $this->widget('site\frontend\modules\posts\modules\contractubex\widgets\mainPosts\MainPostWidget', compact('model')); ?>
    </ul>
</div>