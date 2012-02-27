<div class="main">
    <div class="main-in">
        <div class="content-search clearfix">
            <span>Я ищу</span>

            <form method="get" action="">
                <div class="clearfix">
                    <input type="text" name="text" value="<?php echo $text; ?>"/>
                    <button class="btn btn-green-medium"><span><span>Поиск</span></span></button>
                </div>
                <div class="result-count">
                    Всего нашлось <span class="search-highlight"><?php echo $dataProvider->itemCount; ?></span> результатов
                </div>
            </form>
        </div>
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            //'summaryText' => 'Показано',
            'itemView' => '_search', // refers to the partial view named '_post'
            'summaryText' => '{start} - {end} из {count}',
            'pager' => array(
                'header' => 'Страницы',
            ),
            'template' => '{items}
            <div class="pagination pagination-center clearfix">
                <span class="text">показано: {summary}
                </span>
                {pager}
            </div>',
        ));
        ?>
        <div class="pagination pagination-center clearfix">
            <span class="text">
                Показано: 1-15 из 82
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Страницы:
            </span>
            <ul>
                <li class="previous"><a href=""></a></li>
                <li><a href=""><span>1</span></a></li>
                <li><a href=""><span>2</span></a></li>
                <li class="selected"><a href=""><span>321</span></a></li>
                <li><a href=""><span>4</span></a></li>
                <li><a href=""><span>5</span></a></li>
                <li><a href=""><span>6</span></a></li>
                <li><a href=""><span>7</span></a></li>
                <li class="next"><a href=""></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="side-left">

    <div class="content-search-filter">
        <ul>
            <li class="active"><a href=""><span>Все</span>365</a></li>
            <li><a href=""><span>Посты</span>361</a></li>
            <li><a href=""><span>Видео</span>4</a></li>
        </ul>
    </div>

</div>