<div class="main">
    <div class="main-in">
        <div class="content-search clearfix">
            <span>Я ищу</span>

            <form method="get" action="<?php echo $this->createUrl('/cook/recipe/search'); ?>">
                <div class="clearfix">
                    <input type="text" name="text" value="<?php echo $text; ?>"/>
                    <button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
                </div>
                <div class="result-count">
                    Всего нашлось <span class="search-highlight"><?php echo $dataProvider->totalItemCount; ?></span> результатов
                </div>
            </form>
        </div>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'ajaxUpdate' => false,
            'dataProvider' => $dataProvider,
            //'summaryText' => 'Показано',
            'itemView' => '_search', // refers to the partial view named '_post'
            'summaryText' => 'показано: {start} - {end} из {count}',
            'pager' => array(
                'class' => 'MyLinkPager',
                'header' => '',
            ),
            'template' => '{items}
                <div class="pagination pagination-center clearfix">
                    {pager}
                </div>
            ',
            'viewData' => array(
                'search_text' => $text,
                'criteria' => $criteria,
            )
        ));
        ?>
    </div>
</div>
<div class="side-left">

    <div class="content-search-filter">

    </div>

</div>