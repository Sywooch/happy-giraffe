<style type="text/css">
    .choose-type{
        width: 100%;
    }
    .choose-type td{
        text-align: center;
    }
    .choose-type a{
        font-weight: normal;
        font-size: 14px;
        color: #333;
        text-decoration: none;
    }
    .choose-type td.active{
        background: #333;
    }
    .choose-type td.active a{
        color: #fff;
    }
</style>

<br><br>
<?php $sites = SeoSite::model()->findAll(); ?>
<table class="choose-type">
    <tr>
        <?php foreach ($sites as $site): ?>
        <td<?php if ($site_id == $site->id) echo ' class="active"' ?>><a rel="<?=$site->id ?>" href="<?php echo $this->createUrl('/seo/default/index', array('site_id'=>$site->id)) ?>"><?php echo $site->url ?></a></td>
        <?php endforeach; ?>
    </tr>
</table><br><br>
перейти к странице <input type="text" id="page"><br>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'seo-form',
    'enableAjaxValidation'=>false,
    'method'=>'GET',
    'action'=>array('/seo/default')
));?>
<?php echo CHtml::hiddenField('site_id', $site_id) ?>
<?php echo CHtml::dropDownList('year', $year, array('2011'=>2011, '2012'=>2012), array('onchange'=>'submit')) ?>
<?php $this->endWidget(); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'keywords-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'template'=>'{pager}{summary}{items}',
    'columns'=>array(
        array(
            'name'=>'key_name',
            'value'=>'$data->keyword->name',
        ),
        array(
            'name'=>'sum',
            'filter'=>false
        ),
        array(
            'name'=>'avarage',
            'value'=>'$data->GetAverageStats()',
            'filter'=>false
        ),
        array(
            'name'=>'m12',
            'value'=>'$data->m12',
            'header'=>'Дек',
            'filter'=>false
        ),
        array(
            'name'=>'m11',
            'value'=>'$data->m11',
            'header'=>'Ноя',
            'filter'=>false
        ),
        array(
            'name'=>'m10',
            'filter'=>false
        ),
        array(
            'name'=>'m9',
            'filter'=>false
        ),
        array(
            'name'=>'m8',
            'filter'=>false
        ),
        array(
            'name'=>'m7',
            'filter'=>false
        ),
        array(
            'name'=>'m6',
            'filter'=>false
        ),
        array(
            'name'=>'m5',
            'filter'=>false
        ),
        array(
            'name'=>'m4',
            'filter'=>false
        ),
        array(
            'name'=>'m3',
            'filter'=>false
        ),
        array(
            'name'=>'m2',
            'filter'=>false
        ),
        array(
            'name'=>'m1',
            'filter'=>false
        ),
    ),
)); ?>
<script type="text/javascript">
    $('#page').keyup(function(){
        var url = $('.yiiPager li.last a').attr('href')+'/SeoKeyStats_page/'+$(this).val();
        console.log(url);
        $.fn.yiiGridView.update('keywords-grid', {url:url});
    });

    $('#year').change(function(){
        setTimeout('submitForm()',200);
    });

    $('.choose-type a').click(function(){
        console.log($(this).attr('rel'));
        $('#site_id').val($(this).attr('rel'));
        setTimeout('submitForm()',200);
        return false;
    });

    function submitForm(){
        $('#seo-form').submit();
    }
</script>