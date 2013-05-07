<?php
$dataProvider = $model->search();
?>
<div class="search clearfix">

    <div class="input">
        <label>Введите слово или фразу</label>
        <a href="javascript:;" class="remove tooltip" onclick="CompetitorsTable.clearSearch()" title="Очистить  поиск"></a>
        <input type="text" id="keyword" value="<?=$model->key_name ?>">
        <button class="btn btn-green-small">Поиск</button>
    </div>
    <?php $total_count = $dataProvider->totalItemCount ?>
    <?php $this->renderPartial('_count', compact('model', 'freq', 'site_id', 'total_count')); ?>

    <div class="result-filter">
        <label>не показывать<br>используемые<br>
            <input type="checkbox"
                   id="hide-used" <?php if (Yii::app()->user->getState('hide_used') == 1) echo 'checked="checked"' ?>
                   onchange="SeoKeywords.hideUsed(this, function(){document.location.reload()});"></label>
    </div>

</div>
<div class="seo-table table-result mini">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'keywords-grid',
    'dataProvider' => $dataProvider,
//    'afterAjaxUpdate'=>'CompetitorsTable.updateTable()',
    'filter' => null,
    'cssFile' => false,
    'rowCssClassExpression' => '$data->keyword->getClass()',
    'ajaxUpdate'=>false,
    'template' => '<div class="table-box">{items}</div><div class="pagination pagination-center clearfix">{pager}</div>',
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'key_name',
            'type'=>'raw',
            'value' => '$data->keyword->getKeywordAndSimilarArticles('.$section.')',
            'headerHtmlOptions' => array('class' => 'col-1'),
            'htmlOptions' => array('class' => 'col-1')
        ),
        array(
            'name' => 'popular',
            'value' => '$data->keyword->wordstat',
            'header' => '<i class="icon-yandex"></i>'
        ),
        array(
            'name' => 'popularIcon',
            'type' => 'raw',
            'value' => '$data->keyword->getFreqIcon()',
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
        array(
            'name' => 'sites_id',
            'type' => 'raw',
            'value' => '$data->site->name',
            'header' => 'Сайт',
            'filter' => false
        ),
    ),
)); ?>
</div>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'seo-form',
    'enableAjaxValidation' => false,
    'method' => 'GET',
    'action' => array('/competitors/default/index')
));?>
<?php echo CHtml::hiddenField('site_id', $site_id) ?>
<?php echo CHtml::hiddenField('year', $year) ?>
<?php echo CHtml::hiddenField('key_name', $model->key_name) ?>
<?php echo CHtml::hiddenField('freq', $model->freq) ?>
<?php echo CHtml::hiddenField('section', $section) ?>
<?php echo CHtml::hiddenField('SiteKeywordVisit_sort', isset($_GET['SiteKeywordVisit_sort'])?$_GET['SiteKeywordVisit_sort']:'') ?>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $('#year').change(function () {
        submitForm();
    });

    $('.search .input button').click(function () {
        $('#key_name').val($('#keyword').val());
        submitForm();
    });

    $('#keyword').keypress(function (e) {
        if (e.which == 13) {
            $('#key_name').val($('#keyword').val());
            submitForm();
        }
    });

    function submitForm() {
        $('#seo-form').attr('action', window.location.href);
        $('#seo-form').submit();
    }

    var CompetitorsTable = {
        SetFreq:function (freq) {
            $('#freq').val(freq);
            submitForm();
        },
        setYear:function(el){
            $('#year').val($(el).val());
            submitForm();
        },
        sortByFreq:function(){
            if ($('#SiteKeywordVisit_sort').val() == '')
                $('#SiteKeywordVisit_sort').val('popular');
            else
                $('#SiteKeywordVisit_sort').val('');
            submitForm();
        },
        updateTable:function(){
            $('table.items thead tr th:eq(0)').remove();
            $('table.items thead tr th:eq(0)').remove();
            $('table.items thead tr th:eq(0)').remove();
            $('table.items thead tr th:last').remove();
            $('table.items thead tr th:last').remove();

            var tr = '<tr>\
						<th rowspan="2" class="col-1">Ключевое слово или фраза</th>\
						<th rowspan="2"><i class="icon-yandex" onclick="CompetitorsTable.sortByFreq()"></i></th>\
						<th rowspan="2"><i class="icon-freq"></i></th>\
						<th colspan="12">Количество визитов &nbsp;&nbsp;&nbsp; Год <select onchange="CompetitorsTable.setYear(this);"><option value="2011"<?php if ($model->year == 2011) echo ' selected' ?>>2011</option><option value="2012"<?php if ($model->year == 2012) echo ' selected' ?>>2012</option><option value="2013"<?php if ($model->year == 2013) echo ' selected' ?>>2013</option></select></th>\
						<th rowspan="2"></th>\
						<th rowspan="2"></th>\
					</tr>';


            $('table.items thead').prepend(tr);
        },
        clearSearch:function(){
            $('#key_name').val('');
            submitForm();
        }
    };

    $(function () {
        CompetitorsTable.updateTable();
    });
</script>