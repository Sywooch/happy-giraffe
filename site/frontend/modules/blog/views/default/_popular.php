
    <?php $popular_articles = $this->user->getBlogPopular() ?>
    <?php if (!empty($popular_articles)): ?>
        <div class="fast-articles2">
            <div class="fast-articles2_t-ico"></div>
            <?php foreach ($this->user->blogPopular as $b): ?>
                <?php $this->renderPartial('_popular_one', compact('b')); ?>
            <?php endforeach; ?>
        </div>
    <?php endif;
