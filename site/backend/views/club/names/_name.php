<?php
/* @var $this Controller
 * @var $data Name
 */
$this->renderPartial('__name',array(
    'id' => $data->id,
    'name' => $data->name,
    'gender' => $data->gender,
    'translate' => $data->translate,
    'num'=>$num
))
?>