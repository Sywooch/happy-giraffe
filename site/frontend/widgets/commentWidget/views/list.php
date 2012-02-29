<div class="comments">
    <div class="c-header">
        <div class="left-s">
            <span>Комментарии</span>
            <span class="col"><?php echo $dataProvider->totalItemCount; ?></span>
        </div>
        <div class="right-s">
            <!--<b><a href="">Подписаться</a></b>-->
            <a class="btn btn-orange" href="#add_comment"><span><span>Добавить комментарий</span></span></a>
        </div>
        <div class="clear"></div>
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
        'template' => '{items}
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