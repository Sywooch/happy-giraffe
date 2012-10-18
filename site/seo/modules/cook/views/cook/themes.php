<?php
/* @var $this Controller
 * @var $model Keyword
 */
?><div class="search clearfix">

    <div class="input">
        <label>Введите слово или фразу</label>
        <a href="javascript:;" class="remove tooltip" onclick="KeywordsTable.clearSearch()" title="Очистить  поиск"></a>
        <input type="text" id="keyword" value="<?=$model->name ?>">
        <button class="btn btn-green-small">Поиск</button>
    </div>

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
    'dataProvider' => $model->searchByTheme($theme),
//    'afterAjaxUpdate'=>'CompetitorsTable.updateTable()',
    'filter' => null,
    'cssFile' => false,
    'rowCssClassExpression' => '$data->getClass()',
    'ajaxUpdate'=>false,
    'template' => '<div class="table-box">{items}</div><div class="pagination pagination-center clearfix">{pager}</div>',
//        'summaryText' => 'показано: {start} - {end} из {count}',
    'pager' => array(
        'class' => 'MyLinkPager',
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'name',
            'header' => 'Ключевое слово или фраза',
            'type'=>'raw',
            'value' => '$data->getKeywordAndSimilarArticles()',
            'headerHtmlOptions' => array('class' => 'col-1'),
            'htmlOptions' => array('class' => 'col-1')
        ),
        array(
            'name' => 'popularIcon',
            'type' => 'raw',
            'value' => 'isset($data->yandex)?$data->yandex->getFreqIcon():""',
            'header' => '<i class="icon-freq"></i>'
        ),
        array(
            'name' => 'popular',
            'value' => 'isset($data->yandex)?$data->yandex->value:""',
            'header' => '<i class="icon-yandex"></i>'
        ),
        array(
            'name' => 'buttons',
            'value' => '$data->getButtons()',
            'type' => 'raw',
            'header' => '',
            'filter' => false
        ),
    ),
)); ?>
</div>

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'seo-form',
    'enableAjaxValidation' => false,
    'method' => 'GET',
    'action' => array('/keywords/default/index')
));?>
<?= CHtml::hiddenField('name', $model->name) ?>
<?= CHtml::hiddenField('theme', $theme) ?>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $('.search .input button').click(function () {
        $('#name').val($('#keyword').val());
        submitForm();
    });

    $('#keyword').keypress(function (e) {
        if (e.which == 13) {
            $('#name').val($('#keyword').val());
            submitForm();
        }
    });

    function submitForm() {
        $('#seo-form').attr('action', window.location.href);
        $('#seo-form').submit();
    }

    var KeywordsTable = {
        SetFreq:function (freq) {
            $('#freq').val(freq);
            submitForm();
        },
        updateTable:function(){
            $('table.items thead tr th:eq(0)').remove();
            $('table.items thead tr th:eq(0)').remove();
            $('table.items thead tr th:eq(0)').remove();
            $('table.items thead tr th:last').remove();

            var tr = '<tr>\
                    <th class="col-1" style="width:550px;">Ключевое слово или фраза</th>\
                    <th><i class="icon-freq"></i></th>\
                    <th>Частота показов</th>\
                    <th>Действие</th>\
                </tr>';


            $('table.items thead').prepend(tr);
        },
        clearSearch:function(){
            $('#name').val('');
            submitForm();
        }
    };

    $(function () {
        KeywordsTable.updateTable();
    });
</script>