<?php
/* @var $this Controller
 * @var $data Name
 */
?>
<a class="man_names_lk dislike_nm" href="<?php echo $this->createUrl('/names/default/name', array('name'=>$data->name)) ?>">
    <?php echo $data->name ?>
</a>
<span>"Возрождение", "Воскрешение"</span>
<!--<a class="like" obj_id='--><?php //echo $data->id ?><!--' href="#">like</a><br>-->