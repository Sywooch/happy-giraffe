<?php if($this->beginCache('blog-popular', array(
    'duration' => 600,
    'varyByParam' => array('user_id'),
))): ?>
    <?php $popular_articles = $this->user->getBlogPopular() ?>
    <?php if (!empty($popular_articles)):?>
        <div class="fast-articles2">
            <div class="fast-articles2_t-ico"></div>
            <?php foreach ($this->user->blogPopular as $b): ?>
                <div class="fast-articles2_i">
                    <div class="fast-articles2_header clearfix">

                        <div class="meta-gray">
                            <a href="<?=$b->getUrl(true) ?>" class="meta-gray_comment">
                                <span class="ico-comment ico-comment__gray"></span>
                                <span class="meta-gray_tx"><?=$b->commentsCount ?></span>
                            </a>
                            <div class="meta-gray_view">
                                <span class="ico-view ico-view__gray"></span>
                                <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($b->url)?></span>
                            </div>
                        </div>

                        <div class="float-l">
                            <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $b->created)?></span>
                        </div>
                    </div>
                    <div class="fast-articles2_i-t">
                        <a href="<?=$b->url ?>" class="fast-articles2_i-t-a"><?=$b->title?></a>
                    </div>
                    <div class="fast-articles2_i-desc"><?=$b->getContentText(100, '') ?></div>
                    <?php $photo = $b->getPhoto() ?>
                    <?php if ($photo !== null):?>
                        <div class="fast-articles2_i-img-hold">
                            <a href="<?=$b->url?>"><img src="<?=$photo->getPreviewUrl(190, 300, Image::WIDTH) ?>" alt="" class="fast-articles2_i-img"></a>
                        </div>
                    <?php endif ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif ?>
    <?php $this->endCache(); endif;  ?>