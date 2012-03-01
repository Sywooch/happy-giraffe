<div class="steps steps-comments">
    <a class="btn btn-orange a-right" href="#add_comment"><span><span>Добавить запись</span></span></a>
    <ul>
        <li class="active"><a>Гостевая</a></li>
    </ul>
    <div class="comment-count"><?php echo $dataProvider->totalItemCount; ?></div>
</div>
<div class="default-comments">
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