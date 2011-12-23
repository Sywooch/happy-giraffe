<a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'а')) ?>">а</a>
<a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'б')) ?>">б</a>
<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_name',
    'sortableAttributes'=>false
));
