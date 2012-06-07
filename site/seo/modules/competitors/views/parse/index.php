<?php echo CHtml::dropDownList('site_id', '', CHtml::listData(Site::model()->findAll(), 'id', 'name'), array('id'=>'site-to_parse'));?>
<a href="#" onclick="Competitors.Parse()">Парсить сайт</a>