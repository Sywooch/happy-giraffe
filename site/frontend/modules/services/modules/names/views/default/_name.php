<?php
/* @var $this Controller
 * @var $data Name
 */
$this->renderPartial('__name',array(
    'id' => $data->id,
    'name' => $data->name,
    'slug' => $data->slug,
    'gender' => $data->gender,
    'translate' => $data->translate,
    'like_ids' => $like_ids,
    'num'=>$num
))
?>