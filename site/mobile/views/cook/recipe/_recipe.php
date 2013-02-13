<div class="entry">
    <div class="margin-b10">
        <?=CHtml::link($data->typeString, array('index', 'type' => $data->type, 'section' => $this->section), array('class' => 'text-small'))?>
    </div>
    <?php $this->renderPartial('/_entry_header', array('data' => $data, 'full' => false)); ?>
    <div class="entry-content recipe-article">
        <h2 class="recipe-article_h2">Приготовление</h2>

        <div class="wysiwyg-content">
            <p><?=Str::truncate(strip_tags($data->text), 400)?> <?=CHtml::link('Весь рецепт', $data->url)?></p>
        </div>
    </div>

</div>