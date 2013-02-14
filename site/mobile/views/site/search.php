<div class="search-form clearfix">
    <div class="clearfix">
        <div class="search-form_t">Я ищу</div>
        <div class="search-form_hold">
            <?=CHtml::beginForm('/site/search', 'get')?>
                <input type="text" placeholder="Поиск" class="search-form_itx" name="text">
                <input type="submit" value="Поиск" class="search-form_btn btn-green">
            <?=CHtml::endForm()?>
        </div>
    </div>
    <div class="text-small">Всего нашлось <span class="search-highlight"><?=$allCount?></span> результатов</div>
</div>

<?php $this->widget('MListView', array(
    'dataProvider' => $dp,
    'itemView' => '_search',
    'viewData' => array(
        'full' => false,
        'search_text' => $text,
        'search_index' => $index,
        'criteria' => $criteria,
    ),
    'pager' => array(
        'class' => 'MPager',
    ),
)); ?>