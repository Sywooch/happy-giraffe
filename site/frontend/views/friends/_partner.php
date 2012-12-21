<li>
    <div class="img">
        <?php if ($user->partner->randomPhoto !== null): ?>
        <?=CHtml::image($user->partner->randomPhoto->photo->getPreviewUrl(53, 53), $user->partner->name)?>
        <?php endif; ?>
    </div>
    <span class="yellow"><?=$user->partnerTitleNew?></span> <br />
    <?php if (! empty($user->partner->name)): ?>
        <span><?=$user->partner->name?></span>
    <?php endif; ?>
</li>