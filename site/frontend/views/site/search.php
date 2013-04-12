<?php
Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
?><div class="main">
    <div class="main-in">
        <div class="content-search clearfix">
            <span>Я ищу</span>

            <form method="get" action="<?= $this->createUrl('site/search'); ?>">
                <div class="clearfix">
                    <input type="text" name="text" value="<?= $text; ?>"/>
                    <button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
                </div>
                <div class="result-count">
                    Всего нашлось <span class="search-highlight"><?= ($dataProvider !== null)?$dataProvider->totalItemCount:0 ?></span> результатов
                </div>
            </form>
        </div>
        <?php
        if ($criteria !== null)
        $this->widget('zii.widgets.CListView', array(
            'cssFile'=>false,
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
            <li<?= $index == 'community' ? ' class="active"' : '' ?>><a href="<?= $this->createUrl('/site/search', array('text' => $text)) ?>"><span>Все</span><?= $allCount; ?></a></li>
            <li<?= $index == 'communityText' ? ' class="active"' : '' ?>><a href="<?= $this->createUrl('/site/search', array('text' => $text, 'index' => 'communityText')) ?>"><span>Посты</span><?= $textCount; ?></a></li>
            <li<?= $index == 'communityVideo' ? ' class="active"' : '' ?>><a href="<?= $this->createUrl('/site/search', array('text' => $text, 'index' => 'communityVideo')) ?>"><span>Видео</span><?= $videoCount; ?></a></li>
        </ul>
    </div>

</div>