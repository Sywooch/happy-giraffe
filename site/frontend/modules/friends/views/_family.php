<div class="find-friend-famyli">
    <ul class="find-friend-famyli-list">
        <?php if ($data->hasPartner() && ! empty($data->partner->name)): ?>
            <?php $this->renderPartial('/_partner', array('user' => $data)); ?>
        <?php endif; ?>
        <?php foreach ($data->babies as $b): ?>
            <?php $this->renderPartial('/_baby', array('baby' => $b)); ?>
        <?php endforeach; ?>
    </ul>
</div>