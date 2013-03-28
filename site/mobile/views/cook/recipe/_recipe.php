<div class="entry">
    <?php $this->renderPartial('/_section', array('data' => $data)); ?>
    <?php $this->renderPartial('/_entry_header', array('data' => $data, 'full' => false)); ?>
    <div class="entry-content recipe-article">
        <h2 class="recipe-article_h2">Приготовление</h2>

        <div class="wysiwyg-content">
            <p><?=Str::truncate(strip_tags($data->text), 400)?> <?=CHtml::link('Весь рецепт', $data->url)?></p>
        </div>
    </div>

</div>