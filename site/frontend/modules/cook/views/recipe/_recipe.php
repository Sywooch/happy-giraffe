<article class="b-article b-article__list clearfix">
    <div class="b-article_cont clearfix">
        <div class="b-article_header clearfix">
            <div class="float-l">
                <!-- ava-->
                <a href="<?= $data->author->getUrl() ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid ">
                    <span class="ico-status ico-status__online"></span>
                    <img alt="<?= $data->author->getFullName() ?>" src="<?= $data->author->getAvatarUrl(72) ?>" class="ava_img">
                </a>
                <a href="<?= $data->author->getUrl() ?>" class="b-article_author"><?= $data->author->getFullName() ?></a>
                <?= HHtml::timeTag($data, array('class' => 'tx-date'), null) ?>
            </div>
        </div>
        <div class="b-article_t-list"><a href="<?= $data->url ?>" class="b-article_t-a"><?= $data->title ?></a></div>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <p><?= Str::truncate(strip_tags($data->text), 400) ?></p>
                <?php if ($data->mainPhoto !== null): ?>
                    <div class="b-article_in-img">
                        <?= CHtml::image($data->mainPhoto->getPreviewUrl(580, null, Image::WIDTH), $data->mainPhoto->title, array('class' => 'content-img')) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="textalign-r">
            <a href="<?= $data->url ?>" class="b-article_more">Смотреть далее</a>
        </div>
    </div>
</article>