<?php
/* @var $this Controller
 */
?>
<div class="name_block<?php if (!empty($num) && $num % 3 == 0) echo ' last' ?>">
    <a href="<?php echo $this->createUrl('/names/default/name', array('name' => $name)) ?>" class="<?php
    echo ($gender == 1) ? 'man_names_lk' : 'woman_names_lk'  ?>"><?php
        echo $name ?></a>
    <a rel="<?php echo $id ?>" href="#" class="heart<?php
    if (!in_array($id, $like_ids)) echo ' empty_heart' ?>"></a>
    <p><?php echo $translate ?></p>
</div>
