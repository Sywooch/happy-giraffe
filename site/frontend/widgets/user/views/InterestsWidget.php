<div class="user-interests">
    <div class="box-title">Интересы<?php echo CHtml::link('', array('/ajax/interests'), array('class' => 'interest-add fancy')); ?></div>
    <ul>
        <?php foreach ($user->interests as $interest): ?>
            <li><a href="#" class="interest selected <?php echo $interest->category->css_class ?>"><?php echo $interest->name ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>