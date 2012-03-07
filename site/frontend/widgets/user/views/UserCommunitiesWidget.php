<div class="user-clubs clearfix">

    <div class="box-title">Клубы <a href="">Все клубы (<?php echo $count; ?>)</a></div>

    <ul>
        <?php foreach ($communities as $c): ?>
            <li><?php echo CHtml::link(CHtml::image('/images/community/' . $c->id . '_small.png'), array('community/list', 'community_id' => $c->id)); ?><?php echo CHtml::link($c->name, array('community/list', 'community_id' => $c->id)); ?></li>
        <?php endforeach; ?>
    </ul>

</div>