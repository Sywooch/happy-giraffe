<?php foreach($topMen as $name)
    $this->renderPartial('_name',array('data'=>$name,'like_ids'=>$like_ids)); ?>
<br><br>
<?php foreach($topWomen as $name)
    $this->renderPartial('_name',array('data'=>$name,'like_ids'=>$like_ids)); ?>
