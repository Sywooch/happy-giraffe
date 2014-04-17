<div class="b-article clearfix">
    <?php $this->renderPartial('cook.views.recipe._recipe_parts._controls', array('recipe' => $data)); ?>
    <div class="b-article_cont clearfix">
        <?php $this->renderPartial('cook.views.recipe._recipe_parts._header', array('recipe' => $data, 'full' => false)); ?>
        <div class="b-article_t">
            <a href="<?=$data->url?>" class="b-article_t-a"><?=$data->title?></a>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $data)); ?>
        </div>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <p><?=Str::truncate(strip_tags($data->text), 400)?></p>
                <?php if ($data->mainPhoto !== null): ?>
                    <div class="b-article_in-img">
                        <?=CHtml::image($data->mainPhoto->getPreviewUrl(580, null, Image::WIDTH), $data->mainPhoto->title, array('class' => 'content-img'))?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="textalign-r">
            <a href="<?=$data->url?>" class="b-article_more">Смотреть далее</a>
        </div>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('entity' => 'CookRecipe', 'entity_id' => $data->primaryKey, 'full' => false)); ?>
    </div>
</div>