<?php
/* @var $this Controller
 * @var $data Name
 */
?>
<?php echo CHtml::link($data->name, $this->createUrl('/names/default/name', array('name'=>$data->name)));
?> <a class="like" obj_id='<?php echo $data->id ?>' href="#">like</a><br>