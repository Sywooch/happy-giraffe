<div class="b-article clearfix">
    <?php $this->renderPartial('_recipe_parts/_controls', array('recipe' => $data)); ?>
    <div class="b-article_cont clearfix">
        <?php $this->renderPartial('_recipe_parts/_header', array('recipe' => $data, 'full' => false)); ?>
        <h2 class="b-article_t">
            <a href="<?=$data->url?>" class="b-article_t-a"><?=$data->title?></a>
        </h2>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <?php if ($data->mainPhoto !== null): ?>
                    <div class="b-article_in-img">
                        <?=CHtml::image($data->mainPhoto->getPreviewUrl(580, null, Image::WIDTH), $data->mainPhoto->title, array('class' => 'content-img'))?>
                    </div>
                <?php else: ?>
                    <p><?=Str::truncate(strip_tags($data->text), 400)?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="textalign-r">
            <a href="<?=$data->url?>" class="b-article_more">Смотреть далее</a>
        </div>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data, 'full' => false)); ?>
    </div>
</div>