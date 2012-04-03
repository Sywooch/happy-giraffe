<div class="main">
    <div class="main-in">
        <div class="content-search clearfix">
            <span>Я ищу</span>

            <form method="get" action="<?php echo $this->createUrl('site/search'); ?>">
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
                'search_index' => $index,
                'criteria' => $criteria,
            )
        ));
        ?>
    </div>
</div>
<div class="side-left">

    <div class="content-search-filter">
        <ul>
            <li<?php echo $index == 'community' ? ' class="active"' : '' ?>><a href="<?php echo $this->createUrl('/site/search', array('text' => $text)) ?>"><span>Все</span><?php echo $allCount; ?></a></li>
            <li<?php echo $index == 'communityText' ? ' class="active"' : '' ?>><a href="<?php echo $this->createUrl('/site/search', array('text' => $text, 'index' => 'communityText')) ?>"><span>Посты</span><?php echo $textCount; ?></a></li>
            <li<?php echo $index == 'communityVideo' ? ' class="active"' : '' ?>><a href="<?php echo $this->createUrl('/site/search', array('text' => $text, 'index' => 'communityVideo')) ?>"><span>Видео</span><?php echo $videoCount; ?></a></li>
        </ul>
    </div>

</div>