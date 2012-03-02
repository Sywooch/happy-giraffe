<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 *
 * @var $user User
 */
?>
<style type="text/css">
    .yellow{
        background:#fff9bc;
    }
    .green{
        background:#bef2b9;
    }
    .blue{
        background:#bfddff;
    }
    .orange{
        background:#ffe4b5;
    }
    .purple{
        background:#e5d2f7;
    }
</style>
<div class="user-interests">

    <div class="box-title">Интересы</div>

    <ul>
        <?php foreach ($user->interests as $interest): ?>
            <li><a href="#" class="<?php echo $interest->category->css_class ?>"><?php echo $interest->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>