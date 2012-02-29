<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 *
 * @var $user User
 */
if ($this->visible){
?><div class="user-interests">

    <div class="box-title">Интересы</div>

    <ul>
        <?php foreach ($user->interests as $interest): ?>
            <li><a href="#" class="<?php echo $interest->category->css_class ?>"><?php echo $interest->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</div><?php }