<?php foreach($topMen as $name)
    $this->renderPartial('_name',array('data'=>$name)); ?>
<br><br>
<?php foreach($topWomen as $name)
    $this->renderPartial('_name',array('data'=>$name)); ?>
