<?php
/* @var $topMen Name[]
 * @var $topWomen Name[]
 */
?>
<div class="top_boys">
    <?php foreach($topMen as $name): ?>
    <div class="name_block">
        <div class="heart_like"><?php echo $name->likes ?></div>
        <a href="<?php echo $this->createUrl('name', array('name' => $name->slug)) ?>" class="<?php
            echo ($name->gender == 1) ? 'man_names_lk' : 'woman_names_lk'  ?>"><?php
            echo $name->name ?></a>
        <a rel="<?php echo $name->id ?>" href="#" onclick="return NameModule.like(this);" class="heart<?php
            if (!in_array($name->id, $like_ids)) echo ' empty_heart' ?>"></a>
        <p><?php echo $name->translate ?></p>

        <div class="clear"></div>
    </div>
    <?php endforeach; ?>
</div>

<div class="top_girls">
    <?php foreach($topWomen as $name): ?>
    <div class="name_block">
        <div class="heart_like"><?php echo $name->likes ?></div>
        <a href="<?php echo $this->createUrl('name', array('name' => $name->slug)) ?>" class="<?php
            echo ($name->gender == 1) ? 'man_names_lk' : 'woman_names_lk'  ?>"><?php
            echo $name->name ?></a>
        <a rel="<?php echo $name->id ?>" href="#" onclick="return NameModule.like(this);" class="heart<?php
            if (!in_array($name->id, $like_ids)) echo ' empty_heart' ?>"></a>
        <p><?php echo $name->translate ?></p>

        <div class="clear"></div>
    </div>
    <?php endforeach; ?>
</div>