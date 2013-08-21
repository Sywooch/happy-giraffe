<div class="widget-friends clearfix">
    <div class="clearfix">
        <span class="heading-small">Участники клуба <span class="color-gray">(<?= $user_count ?>)</span> </span>
    </div>
    <ul class="widget-friends_ul clearfix">
        <?php foreach ($users as $user): ?>
            <li class="widget-friends_i">
                <?php $this->widget('Avatar', array('user' => $user)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>