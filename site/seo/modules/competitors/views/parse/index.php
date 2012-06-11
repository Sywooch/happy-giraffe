<div class="form">

    <div class="row">
        <?php echo CHtml::label('Выберите сайт', 'site');
        echo CHtml::dropDownList('site_id', '', CHtml::listData(Site::model()->findAll(), 'id', 'name'), array('id' => 'site')) . '<br>'; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Выберите сайт', 'site');
        echo CHtml::dropDownList('year', 2012, array(2012 => 2012, 2011 => 2011), array('id' => 'year')) . '<br>';?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Выберите месяц с которого парсить', 'site');
        echo CHtml::textField('month_from', 1, array('id' => 'month_from')) . '<br>'; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Выберите месяц до которого парсить', 'site');
        echo CHtml::textField('month_to', 5, array('id' => 'month_to')) . '<br>'; ?>
    </div>

    <?php echo CHtml::link('Парсить сайт', '#', array('onclick' => 'Competitors.Parse(1)')); ?>
    <br>
    <?php echo CHtml::link('посмотреть страницу', '#', array('onclick' => 'Competitors.Parse(2)')); ?>
    <br>
    <input type="text" value="" style="width:400px;">
    <?php echo CHtml::link('установить куки', '#', array('onclick' => 'SeoModule.setConfigAttribute("liveinternet-cookie", $(this).prev().val())')); ?>

    <input type="text" value="" style="width:400px;">
    <?php echo CHtml::link('дополнить урл', '#', array('onclick' => 'SeoModule.setConfigAttribute("liveinternet-add-url", $(this).prev().val())')); ?>

</div>