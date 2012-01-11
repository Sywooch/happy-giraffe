<?php
/* @var $this Controller
 */
?>
<a href="<?php echo $this->createUrl('/names/default/name', array('name'=>$name)) ?>" class="<?php
    echo ($gender == 1)?'man_names_lk':'woman_names_lk'  ?>"><?php
    echo $name ?></a>
<a rel="<?php echo $id ?>" href="#" class="like-btn <?php
if (in_array($id, $like_ids)) echo 'like_nm'; else echo 'dislike_nm' ?>">&nbsp;</a>
<span><?php echo $translate ?></span>