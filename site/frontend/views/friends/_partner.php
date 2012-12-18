<li>
    <?php if ($user->partner->randomPhoto !== null): ?>
        <div class="img"><?=CHtml::image($user->partner->randomPhoto->photo->getPreviewUrl(66, 66), $user->partner->name)?></div>
    <?php endif; ?>
    <span class="yellow"><?=$user->partnerTitleNew?></span> <br />
    <?php if (! empty($user->partner->name)): ?>
        <span><?=$user->partner->name?></span>
    <?php endif; ?>
</li>