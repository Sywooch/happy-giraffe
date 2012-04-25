<div class="name_block<?php if (!empty($num) && $num % 3 == 0) echo ' last' ?>">
    <a href="<?php echo $this->createUrl('/names/default/name', array('name' => $slug)) ?>" class="<?php
    echo ($gender == 1) ? 'boy' : 'girl'  ?>"><?php
        echo $name ?></a>
    <a rel="<?php echo $id ?>" href="#" onclick="return NameModule.like(this);" class="heart<?php
    if (!in_array($id, $like_ids)) echo ' empty_heart' ?>"></a>
    <p><?php echo $translate ?></p>
</div>
<?php if ($num % 3 == 0) echo '</div><div class="clearfix">'; ?>