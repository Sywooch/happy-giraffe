<div class="search clearfix">

    <div class="input">
        <label>Введите слово или фразу</label>
        <input type="text">
        <button class="btn btn-green-small">Поиск</button>
    </div>

    <div class="result">
        <label>Найдено: <a href="">25 365</a></label>
        <span><i class="icon-freq-1"></i> <a href="">5 615</a></span>
        <span><i class="icon-freq-2"></i> <a href="">5 615</a></span>
        <span><i class="icon-freq-3"></i> <a href="">5 615</a></span>
        <span class="active"><i class="icon-freq-4"></i> <a href="">5 615</a></span>
    </div>

    <div class="result-filter">
        <label>не показывать<br>используемые<br><input type="checkbox"></label>
    </div>

</div>


<div class="seo-table table-result mini">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'keywords-grid',
    'dataProvider' => $model->search($recOnPage),
    'filter' => null,
    'cssFile' => false,
    'rowCssClassExpression' => '$data->getRowClass()',
//    'ajaxUpdate'=>false,
    'template' => '<div class="table-box">{items}</div><div class="pagination pagination-center clearfix">{pager}</div>',
//        'summaryText' => 'показано: {start} - {end} из {count}',
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'key_name',
            'value' => '$data->keyword->name',
            'headerHtmlOptions' => array('class' => 'col-1'),
            'htmlOptions' => array('class' => 'col-1')
        ),
        array(
            'name' => 'popular',
            'header' => '<i class="icon-yandex"></i>'
        ),
        array(
            'name' => 'popularCategory',
            'header' => '<i class="icon-freq"></i>'
        ),
        array(
            'name' => 'm1',
            'filter' => false
        ),
        array(
            'name' => 'm2',
            'filter' => false
        ),
        array(
            'name' => 'm3',
            'filter' => false
        ),
        array(
            'name' => 'm4',
            'filter' => false
        ),
        array(
            'name' => 'm5',
            'filter' => false
        ),
        array(
            'name' => 'm6',
            'filter' => false
        ),
        array(
            'name' => 'm7',
            'filter' => false
        ),
        array(
            'name' => 'm8',
            'filter' => false
        ),
        array(
            'name' => 'm9',
            'filter' => false
        ),
        array(
            'name' => 'm10',
            'filter' => false
        ),
        array(
            'name' => 'm11',
            'value' => '$data->m11',
            'header' => 'Ноя',
            'filter' => false
        ),
        array(
            'name' => 'm12',
            'value' => '$data->m12',
            'header' => 'Дек',
            'filter' => false
        ),
        array(
            'name' => 'buttons',
            'type' => 'raw',
            'header' => '',
            'filter' => false
        ),
    ),
)); ?>
</div>


<script type="text/javascript">
    $('#page').keyup(function () {
        var url = $('.yiiPager li.last a').attr('href').replace(/KeyStats_page=[\d]+/, "");
        url = url + '&KeyStats_page=' + $(this).val();
        console.log(url);
        $.fn.yiiGridView.update('keywords-grid', {url:url});
    });

    $('#year').change(function () {
        setTimeout('submitForm()', 200);
    });

    $('#recOnPage').change(function () {
        setTimeout('submitForm()', 200);
    });

    $('.choose-type a').click(function () {
        console.log($(this).attr('rel'));
        $('#site_id').val($(this).attr('rel'));
        setTimeout('submitForm()', 200);
        return false;
    });

    function submitForm() {
        $('#seo-form').attr('action', window.location.href);
        $('#seo-form').submit();
    }
</script>

<style type="text/css">
    .pagination {
        font-size: 23px;
        padding: 15px 0;
        color: #ababab;
        font-family: times new roman, serif;
        font-style: italic;
        line-height: 1;
    }

    .pagination.pagination-center {
        text-align: center;
    }

    .pagination .pager {
        text-align: left;
    }

    .pagination.pagination-center .pager {
        text-align: center;
    }

    .pagination ul {
        list-style: none;
    }

    .pagination ul li {
        display: inline-block;
        padding: 6px 8px;
        text-indent: 0 !important;
        margin: 0 !important;
        position: relative;
    }

    .pagination ul li a {
        padding: 0 3px;
        display: block;
        color: #45a5c9;
    }

    .pagination ul li.selected {
        background: #f1e4fd;
    }

    .pagination ul li.selected img {
        position: absolute;
        top: -9px;
        width: 100%;
        left: 0;
        height: 9px;
    }

    .pagination ul li.selected a {
        color: #7f8181;
        text-decoration: none;
    }

    .pagination ul li.previous a, .pagination ul li.next a {
    }

    .pagination ul li.next a {
        background-position: -157px -101px;
    }

    .pagination .hidden {
        display: none;
    }
</style>