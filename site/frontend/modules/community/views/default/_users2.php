<div class="readers2 js-community-subscription">
    <a class="btn-green btn-medium" href="" data-bind="click: subscribe, visible: !active()">Вступить в клуб</a>
    <ul class="readers2_ul clearfix">
        <?php foreach ($users as $user): ?>
            <li class="readers2_li clearfix">
                <?php $this->widget('Avatar', array('user' => $user, 'size' => Avatar::SIZE_MICRO)); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="clearfix">
        <div class="readers2_count">Все участники клуба (<?= $user_count ?>)</div>
    </div>
</div>