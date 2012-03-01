<div class="default-comments">
    <div class="comments-meta">
        <a href="#add_comment" class="btn btn-orange a-right"><span><span>Добавить запись</span></span></a>
        <div class="title"><?php echo $this->title; ?></div>
        <div class="count"><?php echo $dataProvider->totalItemCount; ?></div>
    </div>
    <?php
    $this->widget('MyListView', array(
        'dataProvider' => $dataProvider,
        //'summaryText' => 'Показано',
        'itemView' => '_comment', // refers to the partial view named '_post'
        'summaryText' => 'показано: {start} - {end} из {count}',
        'pager' => array(
            'class' => 'MyLinkPager',
            'header' => 'Страницы',
        ),
        'id' => 'comment_list',
        'template' => '<ul>{items}</ul>
                <div class="pagination pagination-center clearfix">
                    {summary}
                    {pager}
                </div>
            ',
        'viewData' => array(
            'currentPage' => $dataProvider->pagination->currentPage,
        ),
    ));
    ?>
</div>