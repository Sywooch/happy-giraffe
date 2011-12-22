<?php
foreach($data as $model){
    $this->renderPartial('_name',array('data'=>$model->name));
}