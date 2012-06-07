<style type="text/css">
    .choose-type {
        width: 100%;
    }

    .choose-type td {
        text-align: center;
    }

    .choose-type a {
        font-weight: normal;
        font-size: 14px;
        color: #333;
        text-decoration: none;
    }

    .choose-type td.active {
        background: #D9EAFE;
    }

    #seo .grid-view table.items th {
        background: none repeat scroll 0 0 #D9EAFE;
        border: 1px solid #FFFFFF;
        color: #0B509B;
        font-size: 13px;
        font-weight: normal;
        padding: 10px 5px;
        vertical-align: middle;
    }

    #keywords-grid_c0 {
        width: 300px;
    }

    #seo .seo-table .table-box table td {
        padding: 5px;
    }

    #seo .grid-view table.items th a {
        color: #0B509B;
    }

    .grid-view table.items {
        border: none;
    }

    .grid-view table.items tr.odd {
        background: none;
    }

    .grid-view table.items tr.even {
        background: none;
    }

    .grid-view {
        padding: 0;
    }

    .grid-view table.items tr.active {
        background: #F1E4FD;
    }
</style>
<?php $sites = Site::model()->findAll(); ?>
<table class="choose-type">
    <tr>
        <?php foreach ($sites as $site): ?>
        <td<?php if ($site_id == $site->id) echo ' class="active"' ?>><a rel="<?=$site->id ?>"
                                                                         href="<?php echo $this->createUrl('/default/index', array('site_id' => $site->id)) ?>"><?php echo $site->name ?></a>
        </td>
        <?php endforeach; ?>
    </tr>
</table>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'seo-form',
    'enableAjaxValidation' => false,
    'method' => 'GET',
    'action' => array('/default/')
));?>
<div class="clearfix">
    <div style="float: left;">
        <br>
        <?php echo CHtml::hiddenField('site_id', $site_id) ?>
        Выводить строк на
        страницу: <?php echo CHtml::dropDownList('recOnPage', $recOnPage, array(10 => 10, 25 => 25, 50 => 50, 100 => 100)) ?>
        <br>
        Год: <?php echo CHtml::dropDownList('year', $year, array('2011' => 2011, '2012' => 2012)) ?>
    </div>
    <div style="float: right;">
        <br>
        <br>
        перейти к странице <input type="text" id="page" size="4">
    </div>
</div>
<div class="seo-table">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'keywords-grid',
    'dataProvider' => $model->search($recOnPage),
    'filter' => $model,
    'rowCssClassExpression' => '$data->getRowClass()',
//    'ajaxUpdate'=>false,
    'template' => '{pager}{summary}<div class="table-box">{items}</div>',
    'columns' => array(
        array(
            'name' => 'key_name',
            'value' => '$data->keyword->name',
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
<?php $this->endWidget(); ?>
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